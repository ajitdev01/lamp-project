<?php 
// all-students.php - Modern student directory with Tailwind CSS
include "./includes/header.php"; 
include "./db/db.php";

// Get filter parameters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$division_filter = isset($_GET['division']) ? mysqli_real_escape_string($conn, $_GET['division']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name';

// Build query with filters
$query = "SELECT * FROM students_tbl WHERE 1=1";

if ($search) {
    $query .= " AND (name LIKE '%$search%' OR rollno LIKE '%$search%' OR fname LIKE '%$search%')";
}

if ($division_filter && $division_filter != 'all') {
    $query .= " AND division = '$division_filter'";
}

// Sorting
switch($sort) {
    case 'rollno':
        $query .= " ORDER BY rollno ASC";
        break;
    case 'percentage_high':
        $query .= " ORDER BY percentage DESC";
        break;
    case 'percentage_low':
        $query .= " ORDER BY percentage ASC";
        break;
    default:
        $query .= " ORDER BY name ASC";
}

$result = mysqli_query($conn, $query);
$totalStudents = mysqli_num_rows($result);

// Get statistics for summary cards
$statsQuery = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN division != 'Fail' THEN 1 ELSE 0 END) as passed,
    AVG(percentage) as avg_percentage,
    MAX(percentage) as highest
FROM students_tbl";
$statsResult = mysqli_query($conn, $statsQuery);
$stats = mysqli_fetch_assoc($statsResult);
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header with Stats -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fas fa-users text-blue-500 text-3xl"></i>
                    Student Directory
                </h1>
                <p class="text-gray-500 mt-1">Manage and view all student records</p>
            </div>
            <a href="add-form.php" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition flex items-center gap-2 self-start">
                <i class="fas fa-user-plus"></i> Add New Student
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-2xl shadow-md p-5 border-l-4 border-blue-500 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Students</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo $stats['total']; ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-md p-5 border-l-4 border-green-500 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Passed Students</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo $stats['passed']; ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-md p-5 border-l-4 border-purple-500 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Average Percentage</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo round($stats['avg_percentage'], 1); ?>%</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-md p-5 border-l-4 border-yellow-500 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Highest Score</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo round($stats['highest'], 1); ?>%</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-trophy text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-2xl shadow-md p-5 mb-8">
        <form method="GET" action="" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Search by name, roll number or parent name..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                </div>
            </div>
            
            <div class="w-48">
                <select name="division" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    <option value="all">All Divisions</option>
                    <option value="First Division" <?php echo $division_filter == 'First Division' ? 'selected' : ''; ?>>First Division</option>
                    <option value="Second Division" <?php echo $division_filter == 'Second Division' ? 'selected' : ''; ?>>Second Division</option>
                    <option value="Third Division" <?php echo $division_filter == 'Third Division' ? 'selected' : ''; ?>>Third Division</option>
                    <option value="Fail" <?php echo $division_filter == 'Fail' ? 'selected' : ''; ?>>Fail</option>
                </select>
            </div>
            
            <div class="w-48">
                <select name="sort" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    <option value="name" <?php echo $sort == 'name' ? 'selected' : ''; ?>>Sort by Name</option>
                    <option value="rollno" <?php echo $sort == 'rollno' ? 'selected' : ''; ?>>Sort by Roll No</option>
                    <option value="percentage_high" <?php echo $sort == 'percentage_high' ? 'selected' : ''; ?>>Highest Percentage</option>
                    <option value="percentage_low" <?php echo $sort == 'percentage_low' ? 'selected' : ''; ?>>Lowest Percentage</option>
                </select>
            </div>
            
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-sm">
                <i class="fas fa-filter mr-2"></i> Apply Filters
            </button>
            
            <?php if ($search || ($division_filter && $division_filter != 'all')): ?>
                <a href="all-students.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-xl font-medium transition">
                    <i class="fas fa-times mr-2"></i> Clear
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Results Count -->
    <div class="mb-4 flex justify-between items-center">
        <p class="text-gray-600">
            <i class="fas fa-list-ul text-blue-500 mr-2"></i>
            Showing <span class="font-semibold"><?php echo $totalStudents; ?></span> students
        </p>
        <div class="text-sm text-gray-500">
            <i class="fas fa-print cursor-pointer hover:text-blue-600 mr-3" onclick="window.print()"></i>
            <i class="fas fa-download cursor-pointer hover:text-blue-600"></i>
        </div>
    </div>

    <!-- Student Cards Grid -->
    <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php while($data = mysqli_fetch_assoc($result)): 
                $percentage = round($data['percentage'], 1);
                $cardBorderClass = $data['division'] == 'Fail' ? 'border-t-4 border-t-red-500' : 'border-t-4 border-t-green-500';
                $gradeColor = $data['grade'] == 'A+' ? 'text-emerald-600' : ($data['grade'] == 'A' ? 'text-blue-600' : ($data['grade'] == 'B' ? 'text-yellow-600' : 'text-gray-600'));
            ?>
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 <?php echo $cardBorderClass; ?>">
                    <!-- Student Avatar & Basic Info -->
                    <div class="relative bg-gradient-to-r from-blue-500 to-indigo-600 px-4 pt-6 pb-12">
                        <div class="absolute top-3 right-3">
                            <div class="dropdown relative">
                                <button class="text-white/80 hover:text-white transition">
                                    <i class="fas fa-ellipsis-v text-xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center shadow-lg mb-3">
                                <span class="text-4xl font-bold text-blue-600">
                                    <?php echo strtoupper(substr($data['name'], 0, 2)); ?>
                                </span>
                            </div>
                            <h3 class="text-white font-bold text-xl text-center"><?php echo htmlspecialchars($data['name']); ?></h3>
                            <p class="text-blue-100 text-sm">Roll No: <?php echo $data['rollno']; ?></p>
                        </div>
                    </div>
                    
                    <!-- Student Details -->
                    <div class="p-5">
                        <!-- Parents Info -->
                        <div class="space-y-2 mb-4 pb-3 border-b border-gray-100">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-father text-gray-400 w-5"></i>
                                <span class="text-gray-600"><?php echo htmlspecialchars($data['fname'] ?: 'Not provided'); ?></span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-mother text-gray-400 w-5"></i>
                                <span class="text-gray-600"><?php echo htmlspecialchars($data['mname'] ?: 'Not provided'); ?></span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-calendar-alt text-gray-400 w-5"></i>
                                <span class="text-gray-600"><?php echo date('d M Y', strtotime($data['dob'])); ?></span>
                            </div>
                        </div>
                        
                        <!-- Performance -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600">Performance</span>
                                <span class="text-lg font-bold <?php echo $gradeColor; ?>"><?php echo $data['grade'] ?: 'N/A'; ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2.5 rounded-full transition-all" style="width: <?php echo $percentage; ?>%"></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-gray-800"><?php echo $percentage; ?>%</span>
                                <span class="px-2 py-1 rounded-lg text-xs font-semibold <?php echo $data['division'] == 'Fail' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?>">
                                    <?php echo $data['division']; ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Marks Summary -->
                        <div class="grid grid-cols-3 gap-2 mb-4 text-center text-xs">
                            <div class="bg-gray-50 rounded-lg p-2">
                                <div class="font-semibold text-gray-700">Math</div>
                                <div class="font-bold <?php echo $data['math'] >= 33 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $data['math']; ?></div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2">
                                <div class="font-semibold text-gray-700">Science</div>
                                <div class="font-bold <?php echo $data['sc'] >= 33 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $data['sc']; ?></div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2">
                                <div class="font-semibold text-gray-700">English</div>
                                <div class="font-bold <?php echo $data['eng'] >= 33 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $data['eng']; ?></div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2 mt-3">
                            <a href="marksheet.php?ref=<?php echo $data['id']; ?>" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-xl font-medium transition flex items-center justify-center gap-1">
                                <i class="fas fa-file-alt"></i> Marksheet
                            </a>
                            <a href="edit-student.php?id=<?php echo $data['id']; ?>" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(<?php echo $data['id']; ?>, '<?php echo addslashes($data['name']); ?>')" 
                                    class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl transition">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Pagination (Simple version - can be enhanced) -->
        <?php if($totalStudents > 12): ?>
        <div class="flex justify-center mt-10">
            <nav class="flex gap-2">
                <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">Previous</button>
                <button class="px-4 py-2 rounded-lg bg-blue-600 text-white">1</button>
                <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">2</button>
                <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">3</button>
                <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">Next</button>
            </nav>
        </div>
        <?php endif; ?>
        
    <?php else: ?>
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-md p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-graduate text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Students Found</h3>
            <p class="text-gray-500 mb-6">Try adjusting your search or filter criteria</p>
            <a href="add-form.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition">
                <i class="fas fa-plus"></i> Add Your First Student
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-all">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="deleteModalContent">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Delete Student</h3>
            </div>
            <p class="text-gray-600 mb-6">Are you sure you want to delete <span id="deleteStudentName" class="font-semibold"></span>? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                <a href="#" id="deleteConfirmLink" class="flex-1 bg-red-600 hover:bg-red-700 text-white text-center px-4 py-2 rounded-xl transition">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(studentId, studentName) {
    document.getElementById('deleteStudentName').textContent = studentName;
    document.getElementById('deleteConfirmLink').href = 'delete-student.php?id=' + studentId;
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 200);
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>

<style>
.card-hover {
    transition: all 0.3s ease;
}
.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
}
@media print {
    nav, .statistics-cards, .search-filter-bar, .action-buttons, .no-print {
        display: none !important;
    }
}
</style>

<?php include "./includes/footer.php"; ?>