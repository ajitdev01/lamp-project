        <!-- footer / recent activity strip -->
        <footer class="mt-12 pt-6 border-t border-slate-200/80 flex flex-col sm:flex-row justify-between items-center text-sm text-slate-500">
            <div class="flex gap-5">
                <span><i class="far fa-copyright mr-1"></i> 2026 ResultSystem — Academic Intelligence</span>
                <span><i class="fas fa-chart-simple text-slate-400"></i> Real-time analytics</span>
            </div>
            <div class="flex gap-4 mt-3 sm:mt-0">
                <a href="#" class="hover:text-primary-600 transition"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-primary-600 transition"><i class="fab fa-github"></i></a>
                <a href="#" class="hover:text-primary-600 transition"><i class="fas fa-envelope"></i></a>
            </div>
        </footer>
        </div>

        <!-- chart initialization script + mobile navbar toggler -->
        <script>
            // grade distribution chart (pie)
            const ctx = document.getElementById('gradeChart');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['A+ (90-100)', 'A (80-89)', 'B+ (70-79)', 'B/C (60-69)', 'Failing'],
                    datasets: [{
                        data: [32, 44, 18, 9, 5],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f97316', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 8,
                        borderRadius: 12,
                        spacing: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 11,
                                    family: 'Inter'
                                },
                                boxWidth: 10,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f1f5f9',
                            bodyColor: '#cbd5e1'
                        }
                    }
                }
            });

            // mobile menu toggle logic
            const mobileBtn = document.getElementById('mobile-menu-button');
            const navbarMenu = document.getElementById('navbar-menu');
            if (mobileBtn && navbarMenu) {
                mobileBtn.addEventListener('click', () => {
                    navbarMenu.classList.toggle('hidden');
                    navbarMenu.classList.toggle('flex');
                    navbarMenu.classList.toggle('flex-col');
                    navbarMenu.classList.toggle('w-full');
                    navbarMenu.classList.toggle('mt-3');
                });
            }

            // small hover animation for interactive table rows
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', () => {
                    // just a tiny demo effect - can be replaced with actual edit
                    console.log('Row clicked:', row.innerText.slice(0, 50));
                });
            });
        </script>
        </body>

        </html>