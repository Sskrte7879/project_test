<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء عقد تقديم خدمات معلوماتية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10" x-data="{ nonCompete: 'no' }">

    <div class="max-w-3xl mx-auto px-4">
        
        <!-- Top Back Link -->
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 mb-6 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>العودة إلى لوحة التحكم</span>
        </a>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <div class="border-b border-slate-100 pb-5 mb-6">
                <h2 class="text-2xl font-bold text-slate-900">بيانات عقد تقديم خدمات معلوماتية</h2>
                <p class="text-slate-500 text-sm mt-1">يرجى تعبئة الحقول ليقوم النظام بحقنها داخل العقد وتوليد ملف PDF جاهز للطباعة والتوقيع[cite: 2].</p>
            </div>

            <form action="{{ route('contracts.generate') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Section 1: Parties -->
                <div>
                    <h3 class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-4">1. أطراف العقد</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">اسم المطور / المنفذ *</label>
                            <input type="text" name="dev_name" required class="w-full p-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">اسم الزبون / الشركة *</label>
                            <input type="text" name="client_name" required class="w-full p-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Details -->
                <div>
                    <h3 class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-4">2. تفاصيل المشروع والمالية</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">وصف المشروع والخدمات *</label>
                            <textarea name="project_desc" rows="3" required placeholder="مثال: تطوير تطبيق جوال وموقع إلكتروني لإدارة المبيعات..." class="w-full p-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">المقابل المالي الإجمالي (بالدرهم) *</label>
                                <input type="number" step="0.01" name="price" required class="w-full p-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">مدة الدعم الفني المجاني (بالأشهر) *</label>
                                <input type="number" name="support_months" value="3" required class="w-full p-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Dynamic Legal Clauses -->
                <div class="pt-2 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-4">3. الشروط والبنود القانونية التفاعلية</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">نقل الملكية الفكرية للشفرة المصدرية (Source Code)</label>
                            <select name="ip_transfer" class="w-full p-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="yes">نعم — نقل كامل للحقوق بعد السداد الكامل للمبلغ[cite: 2]</option>
                                <option value="no">لا — إعطاء ترخيص الاستعمال فقط مع احتفاظ المطور بالملكية[cite: 2]</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">تفعيل شرط عدم المنافسة (Clause de non-concurrence)</label>
                            <select name="non_compete" x-model="nonCompete" class="w-full p-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="no">لا — لا يوجد شرط عدم منافسة</option>
                                <option value="yes">نعم — تفعيل شرط عدم المنافسة الجغرافي[cite: 2]</option>
                            </select>
                        </div>

                        <!-- Conditional Fields -->
                        <div x-show="nonCompete === 'yes'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">المدينة / النفوذ الجغرافي *</label>
                                <input type="text" name="compete_city" placeholder="مثال: الدار البيضاء" class="w-full p-3 bg-white rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">مدة المنع (بالأشهر) *</label>
                                <input type="number" name="compete_months" placeholder="12" class="w-full p-3 bg-white rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-md transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>توليد وتحميل العقد (PDF)</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>