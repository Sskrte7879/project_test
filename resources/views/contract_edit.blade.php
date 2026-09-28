<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تعديل العقد — ') . $contract->client_name }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen" dir="rtl" x-data="{ non_compete: '{{ old('non_compete', $contract->non_compete) }}' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl border border-gray-200 p-8">
                
                <div class="mb-8 pb-4 border-b border-gray-100">
                    <h1 class="text-2xl font-extrabold text-gray-900 mb-1">تعديل بيانات العقد</h1>
                    <p class="text-xs text-gray-500">قم بتعديل البيانات المطلوبة ثم انقر على حفظ التعديلات.</p>
                </div>

                <form action="{{ route('contracts.update', $contract->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Client Name & Dev Name -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">اسم العميل (Client Name)</label>
                            <input type="text" name="client_name" value="{{ old('client_name', $contract->client_name) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">
                            @error('client_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">اسم المطور / الشركة (Developer Name)</label>
                            <input type="text" name="dev_name" value="{{ old('dev_name', $contract->dev_name) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">
                            @error('dev_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Project Description -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">وصف المشروع (Project Description)</label>
                        <textarea name="project_desc" rows="4" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">{{ old('project_desc', $contract->project_desc) }}</textarea>
                        @error('project_desc') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Price & Support Months -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">المبلغ (Price in DH)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $contract->price) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">
                            @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">مدة الدعم والصيانة بالأشهر (Support Months)</label>
                            <input type="number" name="support_months" value="{{ old('support_months', $contract->support_months) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">
                            @error('support_months') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- IP Transfer & Non-Compete Switch -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">نقل الملكية الفكرية (IP Transfer)</label>
                            <select name="ip_transfer" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">
                                <option value="yes" {{ old('ip_transfer', $contract->ip_transfer) === 'yes' ? 'selected' : '' }}>نعم (نقل كامل الحقوق)</option>
                                <option value="no" {{ old('ip_transfer', $contract->ip_transfer) === 'no' ? 'selected' : '' }}>لا (ترخيص استخدام فقط)</option>
                            </select>
                            @error('ip_transfer') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">شرط عدم المنافسة (Non-Compete Clause)</label>
                            <select name="non_compete" x-model="non_compete" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">
                                <option value="no">لا (إلغاء الشرط)</option>
                                <option value="yes">نعم (تفعيل الشرط)</option>
                            </select>
                            @error('non_compete') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Conditional Non-Compete Fields -->
                    <div x-show="non_compete === 'yes'" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-5 rounded-2xl border border-gray-200">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">مدينة عدم المنافسة (City)</label>
                            <input type="text" name="compete_city" value="{{ old('compete_city', $contract->compete_city) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">
                            @error('compete_city') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">مدة عدم المنافسة بالأشهر (Months)</label>
                            <input type="number" name="compete_months" value="{{ old('compete_months', $contract->compete_months) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2.5">
                            @error('compete_months') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">
                            إلغاء
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition shadow-sm">
                            حفظ التعديلات
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>