<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء اتفاقية عدم الإفصاح (NDA)') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen" dir="rtl">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-8">
                <h1 class="text-2xl font-extrabold text-slate-900 mb-2">تعبئة بيانات اتفاقية السرية</h1>
                <p class="text-sm text-slate-500 mb-8">هذه الاتفاقية تحمي المعلومات السرية والملكية الفكرية بين الأطراف.</p>

                <form action="{{ route('nda.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">اسم الطرف المُفصِح (المالك للمعلومات)</label>
                        <input type="text" name="disclosing_party" required class="w-full rounded-xl border-slate-200 bg-slate-50 py-2.5 px-4 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">اسم الطرف المُتلقي (المستلم للمعلومات)</label>
                        <input type="text" name="receiving_party" required class="w-full rounded-xl border-slate-200 bg-slate-50 py-2.5 px-4 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">اسم المشروع أو الغرض من الإفصاح</label>
                        <input type="text" name="project_name" required placeholder="مثال: مناقشة شراكة تقنية لتطوير منصة..." class="w-full rounded-xl border-slate-200 bg-slate-50 py-2.5 px-4 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">مدة التزام السرية (بالسنوات)</label>
                            <input type="number" name="duration_years" value="3" min="1" max="10" required class="w-full rounded-xl border-slate-200 bg-slate-50 py-2.5 px-4 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">المحكمة المختصة (المدينة)</label>
                            <input type="text" name="jurisdiction" value="المحكمة التجارية بالرباط" required class="w-full rounded-xl border-slate-200 bg-slate-50 py-2.5 px-4 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl text-sm transition-all shadow-sm">
                            إنشاء ومعاينة الاتفاقية
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>