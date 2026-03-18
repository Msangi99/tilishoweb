<div class="space-y-8">
    <!-- Header Stats for Staff: parcels I created / transported / received -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <!-- Parcels I created -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm transition-all hover:shadow-2xl hover:-translate-y-1 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center gap-4 mb-6 relative">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                </div>
                <div>
                    <h3 class="font-black text-slate-400 text-[10px] uppercase tracking-[0.2em]">Parcels I Created</h3>
                    <p class="text-xs font-bold text-slate-500">All time</p>
                </div>
            </div>
            <div class="space-y-2 relative">
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-900 tracking-tight">{{ $createdCount }}</span>
                    <span class="text-xs font-bold text-slate-400 capitalize">Parcels</span>
                </div>
                <p class="text-sm font-bold text-amber-600">TZS {{ number_format($createdAmount) }}</p>
            </div>
        </div>

        <!-- Parcels I transported -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm transition-all hover:shadow-2xl hover:-translate-y-1 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center gap-4 mb-6 relative">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <h3 class="font-black text-slate-400 text-[10px] uppercase tracking-[0.2em]">Parcels I Transported</h3>
                    <p class="text-xs font-bold text-slate-500">Assigned as transporter</p>
                </div>
            </div>
            <div class="space-y-2 relative">
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-900 tracking-tight">{{ $transportedCount }}</span>
                    <span class="text-xs font-bold text-slate-400">Parcels</span>
                </div>
                <p class="text-sm font-bold text-blue-600">TZS {{ number_format($transportedAmount) }}</p>
            </div>
        </div>

        <!-- Parcels I received -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm transition-all hover:shadow-2xl hover:-translate-y-1 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center gap-4 mb-6 relative">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                </div>
                <div>
                    <h3 class="font-black text-slate-400 text-[10px] uppercase tracking-[0.2em]">Parcels I Received</h3>
                    <p class="text-xs font-bold text-slate-500">Confirmed to customers</p>
                </div>
            </div>
            <div class="space-y-2 relative">
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-900 tracking-tight">{{ $receivedCount }}</span>
                    <span class="text-xs font-bold text-slate-400">Parcels</span>
                </div>
                <p class="text-sm font-bold text-emerald-600">TZS {{ number_format($receivedAmount) }}</p>
            </div>
        </div>
    </div>

    <!-- Weekly / Monthly Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">This Week</p>
                <p class="mt-1 text-sm font-semibold text-slate-700">Parcels I participated in</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-black text-slate-900">{{ $weekTotalCount }}</p>
                <p class="text-xs font-bold text-emerald-600 mt-1">TZS {{ number_format($weekTotalAmount) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">This Month</p>
                <p class="mt-1 text-sm font-semibold text-slate-700">Parcels I participated in</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-black text-slate-900">{{ $monthTotalCount }}</p>
                <p class="text-xs font-bold text-blue-600 mt-1">TZS {{ number_format($monthTotalAmount) }}</p>
            </div>
        </div>
    </div>

    <!-- Animated Graph Section -->
    <div class="mt-8">
        <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm p-10">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Shipment Trends</h2>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">Parcel volume last 7 days</p>
                </div>
                <div class="flex gap-2">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg text-[10px] font-black text-slate-600 border border-slate-100 uppercase tracking-widest">
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        Parcels
                    </div>
                </div>
            </div>
            
            <div class="h-[300px] w-full relative" wire:ignore>
                <canvas id="shipmentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Scripts for Chart.js -->
    @once
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            initChart();
        });

        function initChart() {
            const ctx = document.getElementById('shipmentChart');
            if(!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Parcels',
                        data: @json($chartData['counts']),
                        borderColor: '#3b82f6',
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const {ctx, canvas} = chart;
                            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
                            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.1)');
                            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
                            return gradient;
                        },
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 4,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#3b82f6',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: 'Inter', size: 10, weight: 'bold' },
                            bodyFont: { family: 'Inter', size: 14, weight: '900' },
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Parcels';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { 
                                color: '#94a3b8', 
                                font: { family: 'Inter', size: 10, weight: 'bold' },
                                padding: 10,
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { 
                                color: '#94a3b8', 
                                font: { family: 'Inter', size: 10, weight: 'bold' },
                                padding: 10
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }

        // Handle Livewire updates
        document.addEventListener('livewire:load', () => {
             initChart();
        });
        
        // Ensure it runs on first load if not using wired:navigated
        initChart();
    </script>
    @endonce
</div>
