        document.addEventListener('DOMContentLoaded', () => {
            // 1. Data Atual
            const dateElement = document.getElementById('currentDate');
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            dateElement.innerHTML = `<i class="bi bi-calendar3 me-1"></i> ${new Date().toLocaleDateString('pt-BR', options)}`;

            // 2. Lógica do Menu Lateral (Toggle)
            const sidebar = document.getElementById('sidebar');
            const wrapper = document.getElementById('mainWrapper');
            const toggleBtn = document.getElementById('toggleSidebar');
            const closeBtn = document.getElementById('closeSidebar');

            const toggleSidebar = () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('show');
                } else {
                    sidebar.classList.toggle('collapsed');
                    wrapper.classList.toggle('expanded');
                }
            };

            toggleBtn.addEventListener('click', toggleSidebar);
            closeBtn.addEventListener('click', toggleSidebar);

            // 3. Alternador de Tema (Claro / Escuro)
            const themeSwitcher = document.getElementById('themeSwitcher');
            const htmlTag = document.documentElement;
            const themeIcon = themeSwitcher.querySelector('i');

            themeSwitcher.addEventListener('click', () => {
                const currentTheme = htmlTag.getAttribute('data-bs-theme');
                if (currentTheme === 'light') {
                    htmlTag.setAttribute('data-bs-theme', 'dark');
                    themeIcon.classList.replace('bi-moon', 'bi-sun');
                } else {
                    htmlTag.setAttribute('data-bs-theme', 'light');
                    themeIcon.classList.replace('bi-sun', 'bi-moon');
                }
            });

            // 4. Inicialização do Gráfico (Chart.js)
            const ctx = document.getElementById('estoqueChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul'],
                    datasets: [
                        {
                            label: 'Entradas',
                            data: [150, 200, 180, 250, 220, 310, 345],
                            borderColor: '#198754',
                            backgroundColor: 'rgba(25, 135, 84, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Saídas',
                            data: [100, 150, 120, 200, 180, 250, 280],
                            borderColor: '#dc3545',
                            backgroundColor: 'transparent',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
