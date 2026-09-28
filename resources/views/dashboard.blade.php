<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('لوحة التحكم — منصة العقود الذكية') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen" dir="rtl" x-data="{ 
        search: '', 
        category: 'all', 
        showPreviewModal: {{ session('open_preview_id') ? 'true' : 'false' }}, 
        previewUrl: '{{ session('open_preview_id') ? route('nda.preview', session('open_preview_id')) : '' }}', 
        downloadUrl: '{{ session('open_preview_id') ? route('nda.pdf', session('open_preview_id')) : '' }}' 
    }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Hero / Header Box -->
            <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-l from-blue-50/50 to-transparent p-6 sm:p-8 border-b border-slate-100">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">اختر العقد المناسب لمشروعك</h1>
                    <p class="text-sm text-slate-500 max-w-2xl">حدد نوع العقد المطلوب أو قم بإدارة عقودك المحفوظة بسهولة. جميع العقود مطابقة للتشريعات وتدعم التوقيع الرقمي.</p>
                </div>

                <!-- Filter & Search Bar -->
                <div class="p-6 bg-white flex flex-col md:flex-row gap-5 justify-between items-center">
                    <div class="w-full md:w-1/2 relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" 
                               x-model="search" 
                               placeholder="ابحث عن نوع العقد..." 
                               class="w-full pl-4 pr-10 py-2.5 rounded-xl border-slate-200 bg-slate-50 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-sm transition-all duration-200">
                    </div>

                    <div class="flex flex-wrap gap-2 w-full md:w-auto bg-slate-100/50 p-1 rounded-xl border border-slate-100">
                        <button @click="category = 'all'" 
                                :class="category === 'all' ? 'bg-white shadow-sm text-blue-700 ring-1 ring-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">الكل</button>
                        <button @click="category = 'التقنية والبرمجة'" 
                                :class="category === 'التقنية والبرمجة' ? 'bg-white shadow-sm text-blue-700 ring-1 ring-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">التقنية والبرمجة</button>
                        <button @click="category = 'حماية البيانات والسرية'" 
                                :class="category === 'حماية البيانات والسرية' ? 'bg-white shadow-sm text-blue-700 ring-1 ring-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">حماية البيانات</button>
                    </div>
                </div>
            </div>

            <!-- Available Contracts Grid -->
            @php
                $templateList = $contracts ?? [
                    [
                        'id' => 'prestation_it',
                        'title' => 'عقد تقديم خدمات معلوماتية',
                        'description' => 'عقد متكامل لتطوير البرمجيات والنظم، يتضمن مراحل التسليم، حقوق الملكية الفكرية، وشروط الصيانة.',
                        'category' => 'التقنية والبرمجة',
                        'badge' => 'موصى به',
                        'active' => true,
                    ],
                    [
                        'id' => 'nda',
                        'title' => 'اتفاقية عدم الإفصاح (NDA)',
                        'description' => 'اتفاقية لحماية المعلومات السرية والمملوكة بين الأطراف قبل بدء المفاوضات أو المشاريع.',
                        'category' => 'حماية البيانات والسرية',
                        'badge' => 'أساسي',
                        'active' => true,
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($templateList as $contract)
        <div x-show="(category === 'all' || category === '{{ $contract['category'] }}') && (search === '' || '{{ $contract['title'] }}'.toLowerCase().includes(search.toLowerCase()))"
             class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-blue-300 flex flex-col justify-between transition-all duration-300">
            <div>
                <div class="flex justify-between items-center mb-4">
                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold tracking-wide">{{ $contract['category'] }}</span>
                    <span class="px-2.5 py-1 {{ $contract['active'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }} rounded-lg text-xs font-bold">
                        {{ $contract['badge'] }}
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-700 transition-colors">{{ $contract['title'] }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-6">{{ $contract['description'] }}</p>
            </div>
            <div class="pt-4 border-t border-slate-50">
                @if($contract['active'])
                    <a href="{{ $contract['id'] === 'nda' ? route('nda.create') : route('contracts.create', ['type' => $contract['id']]) }}" class="w-full flex items-center justify-center gap-2 bg-slate-900 hover:bg-blue-600 text-white py-3 rounded-xl font-bold text-sm transition-all duration-300 shadow-sm hover:shadow">
                        <span>البدء في إنشاء العقد</span>
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @else
                    <span class="w-full flex items-center justify-center gap-2 bg-slate-100 text-slate-400 py-3 rounded-xl font-bold text-sm cursor-not-allowed">
                        قريباً
                    </span>
                @endif
            </div>
        </div>
    @endforeach
</div>

            <!-- Saved Contracts Table Box -->
            <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900">عقودي المحفوظة</h2>
                        <p class="text-sm text-slate-500 mt-1">إدارة العقود التي تم إنشاؤها وتعديلها سابقاً.</p>
                    </div>
                </div>

                @if(isset($savedContracts) && $savedContracts->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[700px] text-right border-collapse text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-bold">
                                    <th class="py-4 px-6">اسم العميل</th>
                                    <th class="py-4 px-6">المبلغ</th>
                                    <th class="py-4 px-6">تاريخ الإنشاء</th>
                                    <th class="py-4 px-6 text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($savedContracts as $contract)
                                    <tr class="hover:bg-slate-50/80 transition-colors duration-150 group">
                                        <td class="py-4 px-6 font-semibold text-slate-900 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                                {{ mb_substr($contract->client_name, 0, 1) }}
                                            </div>
                                            {{ $contract->client_name }}
                                        </td>
                                        <td class="py-4 px-6 text-slate-700 font-medium">
                                            <span class="bg-slate-100 text-slate-800 px-2.5 py-1 rounded-md text-xs font-bold">{{ number_format($contract->price, 2) }} DH</span>
                                        </td>
                                        <td class="py-4 px-6 text-slate-500 text-sm flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $contract->created_at->format('Y/m/d') }}
                                        </td>

                                        <td class="py-4 px-6">
    <div class="flex gap-2 justify-center items-center">
        <!-- Full Page HTML Preview Link -->
        <a href="{{ route('contracts.preview', $contract->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="معاينة">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
        </a>

        <!-- Edit -->
        <a href="{{ route('contracts.edit', $contract->id) }}" class="p-2 text-slate-600 hover:bg-slate-100 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200" title="تعديل">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        </a>

        <!-- Delete -->
        <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا العقد نهائياً؟')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors border border-transparent hover:border-red-100" title="حذف">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </form>
    </div>
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-16 px-4">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-700 mb-1">لا توجد عقود محفوظة</h3>
                        <p class="text-slate-500 text-sm text-center max-w-sm">لم تقم بإنشاء أي عقود بعد. اختر نموذجاً من الأعلى للبدء في بناء أول عقد لك.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Saved NDA Contracts Box -->
<div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden mt-8">
    <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">اتفاقيات عدم الإفصاح المحفوظة (NDA)</h2>
            <p class="text-sm text-slate-500 mt-1">إدارة اتفاقيات السرية الخاصة بمشاريعك.</p>
        </div>
    </div>
    

    @if(isset($savedNdas) && $savedNdas->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-right border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-bold">
                        <th class="py-4 px-6">المشروع</th>
                        <th class="py-4 px-6">الطرف المُفصِح</th>
                        <th class="py-4 px-6">الطرف المُتلقي</th>
                        <th class="py-4 px-6">تاريخ الإنشاء</th>
                        <th class="py-4 px-6 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($savedNdas as $nda)
                        <tr class="hover:bg-slate-50/80 transition-colors duration-150 group">
                            <td class="py-4 px-6 font-semibold text-slate-900">
                                {{ $nda->project_name }}
                            </td>
                            <td class="py-4 px-6 text-slate-700">
                                {{ $nda->disclosing_party }}
                            </td>
                            <td class="py-4 px-6 text-slate-700">
                                {{ $nda->receiving_party }}
                            </td>
                            <td class="py-4 px-6 text-slate-500 text-sm">
                                {{ $nda->created_at->format('Y/m/d') }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex gap-2 justify-center items-center">
                                    <!-- Preview -->
                                    <a href="{{ route('nda.preview', $nda->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="معاينة">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('nda.destroy', $nda->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الاتفاقية نهائياً؟')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors border border-transparent hover:border-red-100" title="حذف">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16 px-4">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3 class="text-base font-bold text-slate-700 mb-1">لا توجد عقود محفوظة</h3>
            <p class="text-slate-500 text-sm text-center max-w-sm">لم تقم بإنشاء أي عقود بعد. اختر نموذجاً من الأعلى للبدء في بناء أول عقد لك.</p>
        </div>
    @endif
</div>

        <!-- Fixed PDF Preview Modal -->
        <div 
            x-show="showPreviewModal" 
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-2 sm:p-6"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl flex flex-col overflow-hidden border border-slate-200"
                 @click.away="showPreviewModal = false; previewUrl = '';"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95">
                 
                <!-- Modal Header -->
                <div class="px-6 py-4 bg-white border-b border-slate-100 flex justify-between items-center flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900">معاينة العقد</h3>
                            <p class="text-xs text-slate-500 font-mono mt-0.5">PDF Preview</p>
                        </div>
                    </div>
                    <button @click="showPreviewModal = false; previewUrl = '';" class="text-slate-400 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body with explicit height and smooth scrolling -->
                <div class="w-full h-[75vh] bg-slate-100 relative flex flex-col overflow-y-auto p-4">
                    <div class="absolute inset-0 flex items-center justify-center text-slate-400 pointer-events-none z-0" x-show="previewUrl !== ''">
                        <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                    
                    <!-- Iframe with controlled height and full layout support -->
                    <iframe :src="previewUrl" 
                            class="w-full h-[1200px] border-0 bg-white shadow-md rounded-xl relative z-10 block">
                    </iframe>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end items-center gap-3 flex-shrink-0">
                    <button @click="showPreviewModal = false; previewUrl = '';" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm">
                        إغلاق
                    </button>
                    <a :href="downloadUrl" download class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm shadow-blue-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        تحميل المستند
                    </a>
                </div>
            </div>
        </div>
    @if (session('success'))
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-sm">
            {{ session('success') }}
        </div>
    </div>
@endif
</x-app-layout>