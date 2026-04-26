<?php
// No top results block anymore
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0f0f14;
            color: #f1f1f1;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #ff4da6;
            text-shadow: 0 0 10px rgba(255, 77, 166, 0.6);
        }

        form {
            max-width: 1400px;
            margin: auto;
        }

        .student-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        fieldset {
            background: #1a1a22;
            border: 1px solid rgba(255, 77, 166, 0.3);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(255, 77, 166, 0.15);
        }

        legend {
            font-weight: bold;
            color: #ff4da6;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        input {
            width: 80%;
            padding: 10px;
            margin: 6px 0 14px 0;
            border-radius: 6px;
            border: 1px solid #333;
            background: #0f0f14;
            color: #fff;
        }

        input:focus {
            outline: none;
            border-color: #ff4da6;
            box-shadow: 0 0 8px rgba(255, 77, 166, 0.6);
        }

        button {
            display: block;
            margin: 30px auto;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            background: #ff4da6;
            color: white;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(255, 77, 166, 0.6);
        }

        .card {
            background: #1a1a22;
            padding: 30px;
            margin: 10px auto;
            border-radius: 12px;
            border: 1px solid rgba(255, 77, 166, 0.2);
            box-shadow: 0 0 15px rgba(255, 77, 166, 0.1);
            height: 82%;
        }

        .pass { color: #4dffb8; font-weight: bold; }
        .fail { color: #ff4d4d; font-weight: bold; }
        .honor { color: #ff66cc; font-weight: bold; }
        .warning { color: #ffaa33; font-weight: bold; }

        @media (max-width: 900px) {
            .student-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<!-- Just a simple heading so the user knows what this page is about -->
<h2>Enter Marks for 5 Students</h2>

<!-- Form sends all input data to the server using POST -->
<form method="post">

<?php 
// Loop through 5 students so I don’t have to repeat the same layout manually
for ($student = 1; $student <= 5; $student++): 
?>
    
    <div class="student-row">

        <!-- LEFT SIDE: this is where the user actually inputs marks -->
        <fieldset>

            <!-- Dynamically shows which student this section belongs to -->
            <legend>Student <?php echo $student; ?></legend>

            <div class="grid">

                <!-- First column: exam scores -->
                <div>
                    <h4>Exam Scores</h4>

                    <!-- 
                        Each input name is unique per student (e.g. s1_score1, s2_score1, etc.)
                        The value part is what keeps the input “sticky” after submitting
                        If nothing was submitted yet, it just stays empty
                    -->
                    <input type="number"
                           name="s<?php echo $student; ?>_score1"
                           placeholder="Score 1"
                           value="<?php echo $_POST["s{$student}_score1"] ?? ''; ?>"
                           required>

                    <input type="number"
                           name="s<?php echo $student; ?>_score2"
                           placeholder="Score 2"
                           value="<?php echo $_POST["s{$student}_score2"] ?? ''; ?>"
                           required>

                    <input type="number"
                           name="s<?php echo $student; ?>_score3"
                           placeholder="Score 3"
                           value="<?php echo $_POST["s{$student}_score3"] ?? ''; ?>"
                           required>
                </div>

                <!-- Second column: subject marks -->
                <div>
                    <h4>Subjects</h4>

                    <?php 
                    // Another loop so I can generate 5 subject inputs per student
                    for ($i = 1; $i <= 5; $i++): 
                    ?>
                        <input type="number"
                               name="s<?php echo $student; ?>_sub<?php echo $i; ?>"
                               placeholder="Subject <?php echo $i; ?>"
                               value="<?php echo $_POST["s{$student}_sub{$i}"] ?? ''; ?>"
                               required>
                    <?php endfor; ?>

                </div>
            </div>
        </fieldset>

        <!-- RIGHT SIDE: this is where results show up -->
        <div>

            <?php 
            // Only calculate and show results after the form has been submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST"): 
            ?>

                <div class="card">
                    <h3>Student <?php echo $student; ?></h3>

                    <?php
                    // Get the submitted scores (default to 0 if something is missing)
                    $score1 = (float) ($_POST["s{$student}_score1"] ?? 0);
                    $score2 = (float) ($_POST["s{$student}_score2"] ?? 0);
                    $score3 = (float) ($_POST["s{$student}_score3"] ?? 0);

                    // Basic calculations
                    $average = ($score1 + $score2 + $score3) / 3;
                    $total = $score1 + $score2 + $score3;
                    $percentage = ($total / 300) * 100;

                    // Output the calculated values
                    echo "<p><strong>Average:</strong> $average</p>";
                    echo "<p><strong>Percentage:</strong> $percentage%</p>";

                    // Simple pass/fail logic based on average
                    echo $average >= 50
                        ? "<p class='pass'>Pass</p>"
                        : "<p class='fail'>Fail</p>";

                    // Honor roll condition:
                    // High average AND at least one very high score
                    if ($average > 90 && ($score1 > 95 || $score2 > 95 || $score3 > 95)) {
                        echo "<p class='honor'>Honor Roll</p>";
                    }

                    // Count how many subjects are failed (< 50)
                    $failCount = 0;
                    for ($i = 1; $i <= 5; $i++) {
                        if ((float)($_POST["s{$student}_sub{$i}"] ?? 0) < 50) {
                            $failCount++;
                        }
                    }

                    // Show number of failed subjects
                    echo "<p><strong>Failed subjects:</strong> $failCount</p>";

                    // If more than 2 fails → probation warning
                    if ($failCount > 2) {
                        echo "<p class='warning'>Academic probation</p>";
                    }
                    ?>
                </div>

            <?php else: ?>
                <!-- Before submission, just show a placeholder so the layout doesn’t feel empty -->
                <div class="card" style="opacity:0.4;">
                    <p>Results will appear here</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

<?php endfor; ?>

<!-- Submit button triggers the POST request -->
<button type="submit">Calculate Results</button>

</form>

</body>
</html>