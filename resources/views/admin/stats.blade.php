<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix@2.0.1/dist/chartjs-chart-matrix.min.js"></script>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Taux de présence</h3>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $metrics['taux_presence'] }}%</p>
            </div>
            <div class="p-3 bg-green-50 rounded-2xl text-green-600 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-50">
            <div class="flex flex-col">
                <span class="text-[10px] text-gray-400 uppercase font-bold">Présents</span>
                <span class="text-sm font-bold text-gray-700">{{ number_format($metrics['presents']) }}</span>
            </div>
            <div class="w-px h-8 bg-gray-100"></div>
            <div class="flex flex-col">
                <span class="text-[10px] text-gray-400 uppercase font-bold">Absents</span>
                <span class="text-sm font-bold text-gray-700">{{ number_format($metrics['absents']) }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Total RDV</h3>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $metrics['total_rdv'] }}</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-2xl text-blue-600 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-2 mt-4">
            <div class="flex items-center gap-1 px-2 py-0.5 rounded-lg bg-green-100 text-green-700">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                </svg>
                <span class="text-xs font-bold">+12%</span>
            </div>
            <span class="text-[11px] text-gray-400 font-medium italic">ce mois</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Rétention</h3>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $metrics['taux_retention'] }}%</p>
            </div>
            <div class="p-3 bg-purple-50 rounded-2xl text-purple-600 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <div class="w-full bg-gray-100 h-1.5 rounded-full mt-4 overflow-hidden">
            <div class="bg-purple-500 h-full rounded-full" style="width: {{ $metrics['taux_retention'] }}%"></div>
        </div>
        <p class="text-[10px] text-gray-400 mt-2 font-medium italic">Fidélité des patients</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
    @php
        // حساب الأيام والساعات من القيمة العشرية
        $days = floor($metrics['attente_moyenne']);
        $hours = round(($metrics['attente_moyenne'] - $days) * 24);
    @endphp

    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Attente Moyenne</h3>
            <div class="flex items-baseline gap-1 mt-1">
                @if($days > 0)
                    <p class="text-3xl font-bold text-gray-900">{{ $days }}</p>
                    <span class="text-xs font-bold text-gray-500 mr-1">j</span>
                @endif
                
                <p class="text-3xl font-bold text-gray-900">{{ $hours }}</p>
                <span class="text-xs font-bold text-gray-500">h</span>
            </div>
        </div>
        <div class="p-3 bg-orange-50 rounded-2xl text-orange-600 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
    
    <div class="flex items-center gap-2 mt-4 text-orange-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-[11px] font-bold italic">Délai moyen de prise de RDV</span>
    </div>
</div>

</div>

        <div class="space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 italic">Évolution des Rendez-vous</h3>
                    <div style="height: 300px;"><canvas id="evolutionChart"></canvas></div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 text-center">Spécialités</h3>
                    <div style="height: 300px;"><canvas id="specialiteChart"></canvas></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-1.5 h-8 bg-green-500 rounded-full mr-3"></span>
                    Démographie des Patients (Âge & Genre)
                </h3>
                <div style="height: 350px;"><canvas id="demographieChart"></canvas></div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="w-1.5 h-8 bg-green-600 rounded-full mr-3"></span>
                        Intensité de l'activité (Heatmap)
                    </h3>
                    <div class="flex items-center text-xs text-gray-400 gap-1">
                        <span>Moins</span>
                        <div class="w-3 h-3 rounded-sm bg-gray-100"></div>
                        <div class="w-3 h-3 rounded-sm bg-green-200"></div>
                        <div class="w-3 h-3 rounded-sm bg-green-400"></div>
                        <div class="w-3 h-3 rounded-sm bg-green-600"></div>
                        <div class="w-3 h-3 rounded-sm bg-green-800"></div>
                        <span>Plus</span>
                    </div>
                </div>
                <div style="height: 400px;"><canvas id="heatmapChart"></canvas></div>
            </div>
        </div>
    </div>

    <script>
        const sharedOptions = { responsive: true, maintainAspectRatio: false };

        // 1. Evolution Chart
        const evolutionData = {!! json_encode($tendancesMois) !!};
        new Chart(document.getElementById('evolutionChart'), {
            type: 'line',
            data: {
                labels: evolutionData.map(d => d.date),
                datasets: [{
                    label: 'Nombre de RDV',
                    data: evolutionData.map(d => d.total_rdv),
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true, tension: 0
                }]
            },
            options: { ...sharedOptions, plugins: { legend: { display: false } },scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0 
                }
            }
        } }
        });

        // 2. Specialite Chart
        const specData = {!! json_encode($statsSpecialites) !!};
        new Chart(document.getElementById('specialiteChart'), {
            type: 'doughnut',
            data: {
                labels: specData.map(d => d.specialite),
                datasets: [{
                    data: specData.map(d => d.total),
                    backgroundColor: ['#6366F1', '#EC4899', '#F59E0B', '#10B981', '#3B82F6']
                }]
            },
            options: { ...sharedOptions, cutout: '70%' }
        });

       // 3. Demographie Chart
        const demoData = {!! json_encode($demographie) !!};

        const ages = [...new Set(demoData.map(d => d.segment_age))];

        new Chart(document.getElementById('demographieChart'), {
            type: 'bar',
            data: {
                labels: ages,
                datasets: [
                    {
                        label: 'Hommes',
                        
                        data: ages.map(a => (demoData.find(d => d.segment_age === a && d.genre.toLowerCase() === 'homme')?.total || 0)),
                        backgroundColor: '#60A5FA', 
                        borderRadius: 6,
                        categoryPercentage: 0.8,
                        barPercentage: 0.6
                    },
                    {
                        label: 'Femmes',
                        data: ages.map(a => (demoData.find(d => d.segment_age === a && d.genre.toLowerCase() === 'femme')?.total || 0)),
                        backgroundColor: '#F472B6', 
                        borderRadius: 6,
                        categoryPercentage: 0.8,
                        barPercentage: 0.6
                    }
                ]
            },
            options: { 
                ...sharedOptions, 
            
                scales: { 
                    x: { stacked: true },
                    y: { 
                        stacked: true,
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    } 
                },
                plugins: {
                    legend: { position: 'bottom' } 
                }
            }
        });

        const affluenceData = {!! json_encode($picsAffluence) !!};

        const joursFr = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        const hoursRange = [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19];

        const fullMatrixData = [];
        joursFr.forEach((day) => {
            hoursRange.forEach(hour => {
                const record = affluenceData.find(d => 
                    d.jour && d.jour.trim().substring(0,3).toLowerCase() === day.toLowerCase() && 
                    parseInt(d.heure) === hour
                );
                fullMatrixData.push({ 
                    x: hour.toString() + 'h', 
                    y: day, 
                    v: record ? record.total : 0 
                });
            });
        });

        new Chart(document.getElementById('heatmapChart'), {
            type: 'matrix',
            data: {
                datasets: [{
                    data: fullMatrixData,
                    backgroundColor(context) {
                        const v = context.dataset.data[context.dataIndex]?.v || 0;
                        if (v === 0) return '#f3f4f6';
                        return v < 2 ? '#9be9a8' : v < 4 ? '#40c463' : v < 6 ? '#30a14e' : '#216e39';
                    },
                
                    width: ({chart}) => (chart.chartArea ? (chart.chartArea.width / hoursRange.length) - 4 : 20),
                    height: ({chart}) => (chart.chartArea ? (chart.chartArea.height / 7) - 4 : 20),
                    borderRadius: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'category', 
                        labels: hoursRange.map(h => h + 'h'),
                        grid: { display: false },
                        ticks: { font: { weight: 'bold' } }
                    },
                    y: {
                        type: 'category', 
                        labels: joursFr,
                        offset: true,
                        grid: { display: false },
                        ticks: { font: { weight: 'bold' } }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `RDV: ${ctx.raw.v}`
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>