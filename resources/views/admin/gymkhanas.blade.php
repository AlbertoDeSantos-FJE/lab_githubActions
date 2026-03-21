@extends('layouts.admin')

@section('title', __('Gestió de Gimcanes'))
@section('header_title', __('Gestió de Gimcanes'))

@section('content')
<div class="flex flex-col gap-10">
    <!-- Hero / Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="space-y-2">
            <span class="text-primary font-black tracking-[0.2em] text-[10px] uppercase bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/10">{{ __('Exploració Urbana') }}</span>
            <h3 class="text-4xl font-black tracking-tight text-slate-900 dark:text-slate-100">{{ __('Gimcanes Actives') }}</h3>
            <p class="text-slate-500 dark:text-slate-400 font-medium">{{ __('Gestiona i supervisa les rutes i experiències interactives.') }}</p>
        </div>
        <button class="bg-primary text-white px-8 py-4 rounded-2xl font-black flex items-center gap-2 shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-sm">
            <span class="material-symbols-outlined">add</span>
            {{ __('Nova Gimcana') }}
        </button>
    </div>

    <!-- Bento-style Data Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Rutes', 'value' => '24', 'icon' => 'route', 'color' => 'text-primary', 'bg' => 'bg-primary/5'],
                ['label' => 'Participants Avui', 'value' => '142', 'icon' => 'groups', 'color' => 'text-primary', 'bg' => 'bg-primary/5'],
                ['label' => 'Temps Mitjà', 'value' => '45m', 'icon' => 'timer', 'color' => 'text-primary', 'bg' => 'bg-primary/5'],
                ['label' => 'Valoració Mitjana', 'value' => '4.8', 'icon' => 'star', 'color' => 'text-secondary', 'bg' => 'bg-secondary/10'],
            ];
        @endphp
        @foreach($stats as $stat)
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-50 dark:border-slate-800 shadow-sm hover:border-primary/20 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-black uppercase tracking-widest">{{ __($stat['label']) }}</p>
                    <div class="w-10 h-10 rounded-xl {{ $stat['bg'] }} flex items-center justify-center {{ $stat['color'] }}">
                        <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">{{ $stat['icon'] }}</span>
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <p class="text-4xl font-black text-slate-900 dark:text-slate-100">{{ $stat['value'] }}</p>
                    @if($stat['icon'] == 'star')
                        <span class="material-symbols-outlined text-secondary text-2xl mb-1" style="font-variation-settings: 'FILL' 1;">star</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm overflow-hidden border border-slate-50 dark:border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Scavenger Hunt Name') }}</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Number of Stages') }}</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Average Duration') }}</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @php
                        $gymkhanas = [
                            ['name' => 'Misteris de Bellvitge', 'type' => 'Arquitectura Moderna', 'stages' => 8, 'duration' => '55 min', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAj-VhJgDXb2ozghp4SAG4o40fjVvYMuL1QxsyWko2-HZbSIq4MN9SrX_Px1eoUONgfxu1Oa1i_JDPquPf4jDW76c9VnWZ8dbZ6BO53ZC4wsdvEloddgjXsW9ca-iL5mZTPnDbKqw7gbAd_Tc3MN83FYpN3ywxNjthcNIo6umWD-wIHjHUkGi-mK_34Z2_wS0fDz3iVTAJI7zTgsn0jxOJ1NB2e1CTXwtUM9Ob44tLJi2EMjMiJXj4n5BIQNQMHfmygY9wsaaF1Eyw'],
                            ['name' => 'Ruta del Patrimoni', 'type' => 'Història i Tradició', 'stages' => 12, 'duration' => '1h 20m', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCNlHmnN2vzjWauDAsyBwi0XYlcrvvkkCBPVyB9A4hX66m45fH4nlmjr9d8-YCblLA4gFVNPL-6DYUnr7I9qToJRQcSKglOFPo_9bWpbkNQJfJVy7c3AXz4zgti0u1EVtkh-4w4pslXYCAEIJQjbGBHDYvo8A2DabCNP4n1wg6L7Y4GMRJCLZrKhyv7yGq5-3KsRBNLpcG3JGty5A8Fe7oUPksaqX5CpIvplP3bqe7yWkcggjdYKjWSjwYF5oCPXD8UanCPiDNs_YM'],
                            ['name' => 'Hospitalet Gastronòmic', 'type' => 'Tapes i Cuina de Barri', 'stages' => 6, 'duration' => '40 min', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCLmUgaIzrgp9_PmYLriir6wxPH7lMEaQr-d-BcS0HNMQTOT89iXRFoNLewoDilOHJ0m4vEDfheWLfUXtVweScZZg9_g3r4V5yz6Cu3p8efdRW8B4nRplHBbRJ4imZacbE_7SEgex7MyDzFS3Q0no_nc99Xm4lXIjZSzPMHTOSfOQ9MkvLpXfC8zMmYf9Rx-gfpRnLkNWwSQ9VuTBe1CvKNKql4gMSSZcnuhWf47Q6dmdiOgUYqLEgt0wf8NdqbtwFWwSnuB0ZRP5c'],
                            ['name' => 'Street Art Walk', 'type' => 'Cultura Urbana', 'stages' => 15, 'duration' => '1h 45m', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDQif1-lddDzRwK9MfjOf_BvpSi26mXULZGwDJgvJBTIG5NOA9xdza866P3rp6gregJKpxF4o-9F8ygPX-KftwyWuJVz8S1XXUT_kQ1Z-ywCZYstz8jYRTDWp10obrUo4lpzDyuNpa2olY6_3YCBqP0FYwhlkFEfpbxmzRQFf6YkDE0RNUnzKkMueewHId2UnIUiIW-ylTps_D_Hxv3h8ZwOkN7SzjrXpIpDswc5RPUNsRJzo_37un3CZah_0gCKQKH2MH7IUNkspM'],
                        ];
                    @endphp
                    @foreach($gymkhanas as $gym)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-16 h-16 rounded-2xl bg-primary/5 flex items-center justify-center overflow-hidden border border-slate-100 dark:border-slate-800 shrink-0">
                                        <img alt="{{ $gym['name'] }}" class="w-full h-full object-cover" src="{{ $gym['img'] }}"/>
                                    </div>
                                    <div class="truncate">
                                        <p class="font-black text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors truncate">{{ __($gym['name']) }}</p>
                                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __($gym['type']) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="px-4 py-1.5 bg-primary/10 dark:bg-slate-800 rounded-xl text-[10px] font-black text-primary dark:text-primary-fixed uppercase tracking-widest border border-primary/10">
                                    {{ $gym['stages'] }} {{ __('Etapes') }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                    <span class="text-xs font-bold">{{ $gym['duration'] }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end gap-3">
                                    <button class="w-10 h-10 rounded-xl flex items-center justify-center text-primary bg-primary/5 hover:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button class="w-10 h-10 rounded-xl flex items-center justify-center text-red-500 bg-red-50 dark:bg-red-950/30 hover:bg-red-100 dark:hover:bg-red-950/50 transition-colors">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-10 py-8 bg-slate-50 dark:bg-slate-800/30 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ __('Mostrant 4 de 24 gimcanes') }}</p>
            <div class="flex gap-2">
                @for($i = 1; $i <= 3; $i++)
                    <button class="w-10 h-10 rounded-xl flex items-center justify-center {{ $i == 1 ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-primary transition-all' }} text-xs font-black">{{ $i }}</button>
                @endfor
                <button class="w-10 h-10 rounded-xl flex items-center justify-center bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection