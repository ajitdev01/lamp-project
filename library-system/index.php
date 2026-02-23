 <?php
    include "./includes/header.php"
    ?>


 <!-- Hero Section -->
 <section class="gradient-bg py-16 md:py-24">
     <div class="container mx-auto px-4">
         <div class="flex flex-col lg:flex-row items-center">
             <div class="lg:w-1/2 mb-12 lg:mb-0">
                 <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight"><?php echo SITESLOGAN ?></h1>
                 <p class="text-lg text-gray-700 mb-8 max-w-lg">
                     A digital solution for modern libraries to manage books, members, and transactions efficiently. Streamline your library operations with our intuitive platform.
                 </p>
                 <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                     <a href="books.php" class="px-8 py-3 bg-blue-600 text-white rounded-lg text-center font-medium hover:bg-blue-700 transition duration-300">
                         Explore Books <i class="fas fa-arrow-right ml-2"></i>
                     </a>
                     <a href="admin" class="px-8 py-3 bg-white text-blue-600 border border-blue-600 rounded-lg text-center font-medium hover:bg-blue-50 transition duration-300">
                         Admin Login <i class="fas fa-lock ml-2"></i>
                     </a>
                 </div>
             </div>
             <div class="lg:w-1/2 flex justify-center">
                 <div class="relative">
                     <div class="w-64 h-64 md:w-80 md:h-80 bg-blue-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-book-reader text-blue-500 text-8xl md:text-9xl"></i>
                     </div>
                     <div class="absolute -top-2 -right-2 md:-top-4 md:-right-4 w-32 h-32 md:w-40 md:h-40 bg-blue-200 rounded-full opacity-70"></div>
                     <div class="absolute -bottom-2 -left-2 md:-bottom-4 md:-left-4 w-24 h-24 md:w-32 md:h-32 bg-blue-300 rounded-full opacity-70"></div>
                 </div>
             </div>
         </div>
     </div>
 </section>

 <!-- Statistics Section -->
 <section class="py-16 bg-white">
     <div class="container mx-auto px-4">
         <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Library at a Glance</h2>
         <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
             <!-- Total Books -->
             <div class="stat-card bg-white p-8 rounded-xl shadow-lg text-center">
                 <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                     <i class="fas fa-book text-blue-600 text-2xl"></i>
                 </div>
                 <h3 class="text-4xl font-bold text-gray-900 mb-2">
                     <span id="total-books">0</span>+
                 </h3>
                 <p class="text-gray-600 text-lg">Total Books</p>
                 <p class="text-gray-500 mt-2">Physical & Digital Collection</p>
             </div>

             <!-- Registered Users -->
             <div class="stat-card bg-white p-8 rounded-xl shadow-lg text-center">
                 <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                     <i class="fas fa-users text-green-600 text-2xl"></i>
                 </div>
                 <h3 class="text-4xl font-bold text-gray-900 mb-2">
                     <span id="registered-users">0</span>+
                 </h3>
                 <p class="text-gray-600 text-lg">Registered Users</p>
                 <p class="text-gray-500 mt-2">Students & Faculty Members</p>
             </div>

             <!-- Books Issued -->
             <div class="stat-card bg-white p-8 rounded-xl shadow-lg text-center">
                 <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                     <i class="fas fa-exchange-alt text-purple-600 text-2xl"></i>
                 </div>
                 <h3 class="text-4xl font-bold text-gray-900 mb-2">
                     <span id="books-issued">0</span>+
                 </h3>
                 <p class="text-gray-600 text-lg">Books Issued</p>
                 <p class="text-gray-500 mt-2">Active Transactions</p>
             </div>
         </div>
     </div>
 </section>

 <!-- Features Section -->
 <section class="py-16 bg-gray-50" id="features">
     <div class="container mx-auto px-4">
         <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">Powerful Features</h2>
         <p class="text-gray-600 text-center max-w-2xl mx-auto mb-12">Everything you need to manage a modern library efficiently</p>

         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
             <!-- Feature 1 -->
             <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                 <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                     <i class="fas fa-book-medical text-blue-600 text-xl"></i>
                 </div>
                 <h3 class="text-xl font-semibold text-gray-900 mb-3">Easy Book Management</h3>
                 <p class="text-gray-600">Add, edit, categorize, and search books with our intuitive interface.</p>
             </div>

             <!-- Feature 2 -->
             <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                 <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                     <i class="fas fa-user-shield text-green-600 text-xl"></i>
                 </div>
                 <h3 class="text-xl font-semibold text-gray-900 mb-3">Secure User Accounts</h3>
                 <p class="text-gray-600">Role-based access control with secure authentication for all users.</p>
             </div>

             <!-- Feature 3 -->
             <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                 <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                     <i class="fas fa-bolt text-purple-600 text-xl"></i>
                 </div>
                 <h3 class="text-xl font-semibold text-gray-900 mb-3">Fast Issue & Return</h3>
                 <p class="text-gray-600">Streamlined process for issuing and returning books with automatic tracking.</p>
             </div>

             <!-- Feature 4 -->
             <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                 <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                     <i class="fas fa-chart-bar text-orange-600 text-xl"></i>
                 </div>
                 <h3 class="text-xl font-semibold text-gray-900 mb-3">Admin Dashboard</h3>
                 <p class="text-gray-600">Comprehensive analytics and reports to monitor library operations.</p>
             </div>
         </div>
     </div>
 </section>

 <!-- Call to Action Section -->
 <section class="py-16 bg-blue-700" id="cta">
     <div class="container mx-auto px-4">
         <div class="max-w-3xl mx-auto text-center">
             <h2 class="text-3xl font-bold text-white mb-6">Join Our Digital Library Today</h2>
             <p class="text-blue-100 text-lg mb-8">
                 Experience seamless book management, easy browsing, and instant access to thousands of resources.
                 Whether you're a student, faculty member, or library staff, we have the right tools for you.
             </p>
             <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                 <a href="./users/register.php" class="px-8 py-3 bg-white text-blue-700 font-medium rounded-lg hover:bg-gray-100 transition duration-300">
                     Create Free Account <i class="fas fa-user-plus ml-2"></i>
                 </a>
                 <a href="books.php" class="px-8 py-3 bg-transparent border-2 border-white text-white font-medium rounded-lg hover:bg-blue-800 transition duration-300">
                     Browse Collection <i class="fas fa-search ml-2"></i>
                 </a>
             </div>
             <p class="text-blue-200 mt-8 text-sm">
                 <i class="fas fa-info-circle mr-2"></i>No credit card required. Full access for educational institutions.
             </p>
         </div>
     </div>
 </section>

 <?php
    include "./includes/footer.php"
    ?>