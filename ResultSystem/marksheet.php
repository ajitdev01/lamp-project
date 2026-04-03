<?php
// marksheet.php - Professional Marksheet with Modern Design
include "./includes/header.php";
include "./db/db.php";

$ref = isset($_GET['ref']) ? (int)$_GET['ref'] : 0;
$query = "SELECT * FROM students_tbl WHERE id = $ref";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo '<div class="max-w-7xl mx-auto px-4 py-12 text-center">
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                <h2 class="text-xl font-bold text-gray-800">Student Not Found</h2>
                <p class="text-gray-600 mt-2">The requested student record does not exist.</p>
                <a href="all-students.php" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Back to Directory</a>
            </div>
          </div>';
    include "footer.php";
    exit;
}

$data = mysqli_fetch_assoc($result);

// Calculate grade point based on marks
function getGradePoint($marks)
{
    if ($marks >= 90) return ['grade' => 'A+', 'point' => 10.0, 'remark' => 'Outstanding'];
    if ($marks >= 80) return ['grade' => 'A', 'point' => 9.0, 'remark' => 'Excellent'];
    if ($marks >= 70) return ['grade' => 'B+', 'point' => 8.0, 'remark' => 'Very Good'];
    if ($marks >= 60) return ['grade' => 'B', 'point' => 7.0, 'remark' => 'Good'];
    if ($marks >= 50) return ['grade' => 'C+', 'point' => 6.0, 'remark' => 'Above Average'];
    if ($marks >= 40) return ['grade' => 'C', 'point' => 5.0, 'remark' => 'Average'];
    if ($marks >= 33) return ['grade' => 'D', 'point' => 4.0, 'remark' => 'Pass'];
    return ['grade' => 'F', 'point' => 0.0, 'remark' => 'Fail'];
}

$subjects = [
    ['name' => 'English', 'code' => 'ENG101', 'marks' => $data['eng']],
    ['name' => 'Mathematics', 'code' => 'MATH102', 'marks' => $data['math']],
    ['name' => 'Science', 'code' => 'SCI103', 'marks' => $data['sc']],
    ['name' => 'Social Science', 'code' => 'SSC104', 'marks' => $data['ssc']],
    ['name' => 'Hindi', 'code' => 'HIN105', 'marks' => $data['hnd']]
];

$totalMarks = 500;
$obtainedMarks = $data['obmarks'];
$percentage = round($data['percentage'], 2);
$isPassed = $data['division'] != 'Fail';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marksheet - <?php echo htmlspecialchars($data['name']); ?> | ResultSystem</title>
    <style>
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .no-print {
                display: none !important;
            }

            .marksheet-container {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 20px !important;
            }

            .print-break {
                page-break-inside: avoid;
            }

            .watermark {
                opacity: 0.05;
            }
        }

        @page {
            size: A4;
            margin: 15mm;
        }

        .marksheet-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        .signature-line {
            border-top: 2px solid #1e293b;
            width: 180px;
            margin-top: 8px;
        }

        .grade-badge {
            transition: all 0.3s ease;
        }

        .grade-badge:hover {
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <div class="max-w-5xl mx-auto px-4 py-8 no-print">
        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6">
            <a href="all-students.php" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-xl transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Directory
            </a>
            <div class="flex gap-3">
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-print"></i> Print Marksheet
                </button>
                <button onclick="downloadAsPDF()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-download"></i> Download PDF
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 pb-8 print-break fade-in">
        <div class="marksheet-card bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200 relative">

            <!-- Watermark -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-5 z-0">
                <i class="fas fa-graduation-cap text-9xl"></i>
            </div>

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 text-white px-8 py-8 text-center relative">
                <div class="absolute top-4 right-4 opacity-20">
                    <i class="fas fa-certificate text-6xl"></i>
                </div>
                <div class="absolute top-4 left-4 opacity-20">
                    <i class="fas fa-school text-6xl"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex justify-center mb-3">
                        <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-chalkboard-user text-4xl text-white"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-wide mb-2">BRAINZIMA INNOVATION INSTITUTE</h1>
                    <p class="text-xl font-light">(Recognized by Department of Education, Bihar)</p>
                    <div class="flex justify-center gap-8 mt-3 text-sm text-blue-200">
                        <span><i class="fas fa-map-marker-alt mr-1"></i> Katihar, Bihar - 854105</span>
                        <span><i class="fas fa-phone mr-1"></i> +91 7808982006</span>
                        <span><i class="fas fa-envelope mr-1"></i> info@brainzima.com</span>
                    </div>
                    <div class="mt-4">
                        <div class="inline-block bg-white/20 px-6 py-2 rounded-full backdrop-blur-sm">
                            <span class="font-semibold">ANNUAL EXAMINATION RESULT - 2026</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificate Title -->
            <div class="text-center py-6 border-b border-gray-200">
                <h2 class="text-3xl font-bold text-gray-800">STATEMENT OF MARKS</h2>
                <p class="text-gray-500 mt-1">(This certificate is issued under the seal of the institute)</p>
            </div>

            <!-- Student Information Section -->
            <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-id-card text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Roll Number</p>
                            <p class="text-xl font-bold text-gray-800"><?php echo $data['rollno']; ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-graduate text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Student Name</p>
                            <p class="text-xl font-bold text-gray-800"><?php echo strtoupper(htmlspecialchars($data['name'])); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Date of Birth</p>
                            <p class="text-lg font-semibold text-gray-800"><?php echo date('d F, Y', strtotime($data['dob'])); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-father text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Father's Name</p>
                            <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($data['fname'] ?: 'Not Provided'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-mother text-pink-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Mother's Name</p>
                            <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($data['mname'] ?: 'Not Provided'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-code-branch text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Admission ID</p>
                            <p class="font-semibold text-gray-800">BISR/2026/<?php echo str_pad($data['id'], 4, '0', STR_PAD_LEFT); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Marks Table -->
            <div class="px-8 py-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-table-list text-blue-600"></i> Subject-wise Performance
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-50 to-indigo-50">
                                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">S.No</th>
                                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Subject Code</th>
                                <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Subject Name</th>
                                <th class="border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700">Max Marks</th>
                                <th class="border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700">Pass Marks</th>
                                <th class="border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700">Obtained</th>
                                <th class="border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700">Grade</th>
                                <th class="border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700">GP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn = 1;
                            $totalGp = 0;
                            foreach ($subjects as $subject):
                                $gradeInfo = getGradePoint($subject['marks']);
                                $totalGp += $gradeInfo['point'];
                                $rowClass = $subject['marks'] < 33 ? 'bg-red-50' : '';
                            ?>
                                <tr class="<?php echo $rowClass; ?> hover:bg-gray-50 transition">
                                    <td class="border border-gray-300 px-4 py-2 text-center"><?php echo $sn++; ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $subject['code']; ?></td>
                                    <td class="border border-gray-300 px-4 py-2 font-medium"><?php echo $subject['name']; ?></td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">100</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">33</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center font-semibold"><?php echo $subject['marks']; ?></td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <span class="grade-badge inline-block w-10 h-10 rounded-full <?php echo $gradeInfo['grade'] == 'F' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?> font-bold text-lg leading-10">
                                            <?php echo $gradeInfo['grade']; ?>
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center font-semibold"><?php echo $gradeInfo['point']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="bg-yellow-50 font-bold">
                                <td colspan="3" class="border border-gray-300 px-4 py-3 text-right">TOTAL</td>
                                <td class="border border-gray-300 px-4 py-3 text-center">500</td>
                                <td class="border border-gray-300 px-4 py-3 text-center">165</td>
                                <td class="border border-gray-300 px-4 py-3 text-center text-lg"><?php echo $obtainedMarks; ?></td>
                                <td class="border border-gray-300 px-4 py-3 text-center">-</td>
                                <td class="border border-gray-300 px-4 py-3 text-center font-bold"><?php echo round($totalGp, 1); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Result Summary -->
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <p class="text-gray-500 text-sm uppercase">Total Marks</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $obtainedMarks; ?>/500</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-500 text-sm uppercase">Percentage</p>
                        <p class="text-2xl font-bold <?php echo $percentage >= 60 ? 'text-green-600' : ($percentage >= 33 ? 'text-yellow-600' : 'text-red-600'); ?>">
                            <?php echo $percentage; ?>%
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-500 text-sm uppercase">Division</p>
                        <p class="text-xl font-bold <?php echo $isPassed ? 'text-green-600' : 'text-red-600'; ?>">
                            <?php echo $data['division']; ?>
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-500 text-sm uppercase">CGPA</p>
                        <p class="text-2xl font-bold text-indigo-600"><?php echo number_format($totalGp / 5, 2); ?></p>
                    </div>
                </div>

                <?php if ($isPassed): ?>
                    <div class="mt-4 text-center">
                        <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full">
                            <i class="fas fa-check-circle"></i>
                            <span class="font-semibold">PROMOTED TO NEXT CLASS</span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-4 text-center">
                        <div class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-full">
                            <i class="fas fa-exclamation-circle"></i>
                            <span class="font-semibold">NOT PROMOTED - NEEDS IMPROVEMENT</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Remarks Section -->
            <div class="px-8 py-4 border-b border-gray-200">
                <div class="flex items-start gap-3">
                    <i class="fas fa-comment-dots text-blue-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-gray-700">Remarks:</p>
                        <p class="text-gray-600">
                            <?php
                            if ($percentage >= 85) echo "Excellent performance! Keep up the great work! 🌟";
                            elseif ($percentage >= 70) echo "Very Good performance. You have shown consistent effort. 👏";
                            elseif ($percentage >= 60) echo "Good performance. Focus more on problem-solving skills. 📚";
                            elseif ($percentage >= 45) return "Satisfactory performance. More dedication needed. 💪";
                            elseif ($percentage >= 33) echo "Passed. Need to work harder for better results. ⚠️";
                            else echo "Failed. Requires serious attention and improvement. Please contact the academic counselor. 📞";
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Signatures and Footer -->
            <div class="px-8 py-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="mb-2">
                            <i class="fas fa-calendar-check text-gray-400 text-lg"></i>
                            <p class="text-sm text-gray-500 mt-1">Result Date</p>
                            <p class="font-semibold"><?php echo date('d M, Y'); ?></p>
                        </div>
                    </div>
                    <div>
                        <div class="signature-line mx-auto mb-2"></div>
                        <p class="font-semibold">Controller of Examinations</p>
                        <p class="text-xs text-gray-500">University Seal</p>
                    </div>
                    <div>
                        <div class="signature-line mx-auto mb-2"></div>
                        <p class="font-semibold">Principal</p>
                        <p class="text-xs text-gray-500">Dr. S.K. Mishra</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-800 text-white px-8 py-4 text-center text-sm rounded-b-2xl">
                <div class="flex flex-wrap justify-center gap-6">
                    <span><i class="fas fa-qrcode mr-1"></i> Verify at: www.brainzima.com/verify</span>
                    <span><i class="fas fa-laptop mr-1"></i> Digitally Generated Document</span>
                    <span><i class="fas fa-shield-alt mr-1"></i> Valid without signature</span>
                </div>
                <p class="text-gray-400 text-xs mt-2">This is a computer-generated marksheet and does not require physical signature. For verification, scan the QR code or visit our website.</p>
            </div>
        </div>
    </div>

    <script>
        function downloadAsPDF() {
            window.print();
        }

        // Add loading animation
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Marksheet loaded successfully');
        });
    </script>

    <?php include "./includes/footer.php"; ?>