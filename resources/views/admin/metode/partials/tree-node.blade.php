@if ($node['type'] === 'leaf')
    <!-- Leaf Node -->
    @php
        $badgeColors = [
            'ringan' => 'bg-emerald-50 border-emerald-300 text-emerald-800 shadow-emerald-500/10',
            'sedang' => 'bg-amber-50 border-amber-300 text-amber-800 shadow-amber-500/10',
            'berat' => 'bg-rose-50 border-rose-300 text-rose-800 shadow-rose-500/10',
        ];
        $label = strtolower($node['label']);
        $color = $badgeColors[$label] ?? 'bg-slate-50 border-slate-300 text-slate-800';
    @endphp
    <div class="inline-flex flex-col items-center p-3 rounded-2xl border-2 {{ $color }} shadow-sm text-center min-w-36 shrink-0">
        <span class="text-[10px] uppercase font-bold tracking-wider opacity-75">Hasil Klasifikasi</span>
        <span class="text-sm font-extrabold uppercase mt-0.5 tracking-tight flex items-center gap-1.5">
            @if ($label === 'ringan')
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
            @elseif ($label === 'sedang')
                <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
            @else
                <i class="fa-solid fa-skull-crossbones text-rose-600"></i>
            @endif
            {{ $node['label'] }}
        </span>
        <span class="text-[11px] font-semibold opacity-70 mt-1">
            {{ $node['total_samples'] }} Sampel &bull; {{ $node['confidence'] }}%
        </span>
    </div>
@else
    <!-- Decision / Split Node -->
    <div class="flex flex-col items-center shrink-0">
        <!-- Node Card -->
        <div class="p-3.5 rounded-2xl bg-white border border-slate-200 shadow-xs text-center min-w-44 shrink-0 hover:border-indigo-300 transition-colors">
            <span class="text-[10px] uppercase font-bold tracking-wider text-indigo-600 block">Atribut Pemisah</span>
            <span class="text-xs font-bold text-slate-800 block mt-0.5">
                {{ $node['attribute_label'] ?? $node['attribute'] }}
            </span>
            <div class="mt-1.5 flex items-center justify-center gap-2 text-[10px] text-slate-500 font-medium">
                <span>Gain: <b class="text-slate-700">{{ $node['gain'] }}</b></span>
                <span>&bull;</span>
                <span>{{ $node['total_samples'] }} Data</span>
            </div>
        </div>

        <!-- Branches Connector -->
        <div class="w-px h-5 bg-slate-300"></div>

        <!-- Branches Row -->
        <div class="flex items-start justify-center gap-6 relative pt-2">
            @php $branchCount = count($node['branches']); @endphp
            @if ($branchCount > 1)
                <!-- Horizontal connector line -->
                <div class="absolute top-2 left-8 right-8 h-px bg-slate-300"></div>
            @endif

            @foreach ($node['branches'] as $val => $childNode)
                <div class="flex flex-col items-center shrink-0">
                    <!-- Branch Value Badge -->
                    <div class="px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-[10px] font-bold text-slate-700 shadow-2xs mb-2 z-10">
                        {{ $val === '1' ? 'Ya' : ($val === '0' ? 'Tidak' : ucfirst($val)) }}
                    </div>
                    <!-- Recursive Child Node -->
                    @include('admin.metode.partials.tree-node', ['node' => $childNode])
                </div>
            @endforeach
        </div>
    </div>
@endif
