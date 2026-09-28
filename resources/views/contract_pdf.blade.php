<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>عقد تقديم خدمات معلوماتية</title>

    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            @bottom-right {
                content: "صفحة " counter(page) " من " counter(pages);
                font-family: 'Amiri', 'DejaVu Sans', sans-serif;
                font-size: 8pt;
                color: #777777;
            }
            @bottom-left {
                content: "وثيقة مُولّدة آلياً — مسجلة إلكترونياً";
                font-family: 'Amiri', 'DejaVu Sans', sans-serif;
                font-size: 8pt;
                color: #777777;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Amiri', 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
            color: #222222;
            font-size: 11pt;
            line-height: 1.8;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #1a365d;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18pt;
            color: #1a365d;
            margin: 0 0 6px 0;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 10pt;
            color: #4a5568;
        }

        .section {
            margin-bottom: 16px;
        }

        .section-title {
            background-color: #f1f5f9;
            border-right: 4px solid #1a365d;
            padding: 6px 10px;
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .party-table,
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .party-table td {
            width: 50%;
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            vertical-align: top;
            background-color: #ffffff;
        }

        .label {
            font-weight: bold;
            color: #1a365d;
        }

        .clause {
            text-align: justify;
            margin-bottom: 8px;
            color: #334155;
        }

        .price {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
        }

        .notice {
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            padding: 10px 12px;
            margin-top: 8px;
            margin-bottom: 8px;
            border-radius: 4px;
        }

        .signature-wrapper {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }

        .signature-line {
            border-bottom: 1px solid #475569;
            height: 45px;
            margin: 15px 25px 10px 25px;
        }

        .footer-notice {
            text-align: center;
            color: #64748b;
            font-size: 8pt;
            margin-top: 20px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 8px;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <h1>
            عقد تقديم خدمات معلوماتية
            <br>
            <span style="font-size: 13pt; font-weight: normal; color: #475569;">(Contrat de Prestation de Services IT)</span>
        </h1>
        <div class="subtitle">
            مُحرر وفقاً للقواعد العامة لقانون الالتزامات والعقود المغربي (DOC) والقوانين التنظيمية ذات الصلة
        </div>
    </div>

    {{-- Section 1 --}}
    <div class="section">
        <div class="section-title">
            المادة 1: الأطراف
        </div>

        <table class="party-table">
            <tr>
                <td>
                    <span class="label">المطور / المنفذ (Le Prestataire):</span>
                    <br>
                    <strong>{{ $contract->dev_name }}</strong>
                </td>
                <td>
                    <span class="label">الزبون / صاحب المشروع (Le Client):</span>
                    <br>
                    <strong>{{ $contract->client_name }}</strong>
                </td>
            </tr>
        </table>

        <p class="clause">
            تم الاتفاق والتراضي بين الطرفين المذكورين أعلاه على إبرام هذا العقد وفقاً للشروط والأحكام الواردة فيه، ومع مراعاة القواعد القانونية المغربية المعمول بها، ولا سيما أحكام قانون الالتزامات والعقود.
        </p>
    </div>

    {{-- Section 2 --}}
    <div class="section">
        <div class="section-title">
            المادة 2: موضوع العقد ونطاق الخدمات
        </div>

        <p class="clause">
            يلتزم المطور / المنفذ بإنجاز وتقديم الخدمات البرمجية والمعلوماتية المحددة أدناه وفقاً للمواصفات والمتطلبات المتفق عليها مع الزبون، وبما يضمن معايير الجودة الفنية والتقنية المتعارف عليها.
        </p>

        <div class="notice">
            <strong>وصف المشروع والخدمات المطلوب تنفيذها:</strong>
            <br>
            {!! nl2br(e($contract->project_desc)) !!}
        </div>
    </div>

    {{-- Section 3 --}}
    <div class="section">
        <div class="section-title">
            المادة 3: المقابل المالي وشروط الأداء
        </div>

        <p class="clause">
            اتفق الطرفان على أن المقابل الإجمالي للخدمات البرمجية موضوع هذا العقد هو:
        <span class="price"><bdi dir="ltr" class="inline-block font-bold">
            {{ number_format($contract->price, 2) }}
        </bdi>درهم مغربي (MAD)</span>
            ، ويشمل جميع الرسوم والضرائب المطبقة.
        </p>

        <p class="clause">
            يتم تسديد المقابل المالي وفق الكيفية والمواعيد المتفق عليها بين الطرفين. ويُعد السداد الكامل والمتكامل للمبلغ المذكور شرطاً واقفاً لإنفاذ نقل حقوق الملكية الفكرية أو تسليم الشفرة المصدرية النهائية في الحالات التي ينص فيها العقد على ذلك.
        </p>
    </div>

    {{-- Section 4 --}}
    <div class="section">
        <div class="section-title">
            المادة 4: الملكية الفكرية والشفرة المصدرية
        </div>

        @if ($contract->ip_transfer === 'yes')
            <p class="clause">
                فور السداد الكامل والتام للمقابل المالي المحدد في المادة الثالثة، ينقل المطور إلى الزبون كافة الحقوق المالية وحقوق الاستغلال المرتبطة بالشفرة المصدرية (Source Code) والعمل البرمجي المنجز خصيصاً بموجب هذا العقد. ويحق للزبون بموجب هذا النقل تعديل، تطوير، واستغلال البرمجية بحرية.
            </p>
        @else
            <p class="clause">
                يحتفظ المطور بالملكية الفكرية الكاملة للشفرة المصدرية (Source Code) والمكونات البرمجية الأساسية. ويمنح الزبون، بعد السداد الكامل للمستحقات المالية، ترخيصاً غير حصري وغير قابل للتفويت لاستعمال الحل البرمجي في الحدود التشغيلية الخاصة به فقط، دون نقل حقوق الملكية الأصلية.
            </p>
        @endif
    </div>

    {{-- Section 5 --}}
    <div class="section">
        <div class="section-title">
            المادة 5: الدعم الفني وإصلاح الأخطاء
        </div>

        <p class="clause">
            يلتزم المطور بتقديم خدمة الصيانة والدعم الفني المجاني لتصحيح الأخطاء والعيوب البرمجية (Bugs) الناتجة مباشرة عن التنفيذ لمدة:
            <strong>
                {{ $contract->support_months }}
                {{ $contract->support_months == 1 ? 'شهر واحد' : ($contract->support_months == 2 ? 'شهراً' : 'أشهر') }}
            </strong>
            ابتداءً من تاريخ التسليم النهائي للمشروع.
        </p>

        <p class="clause">
            لا يشمل هذا الدعم أي تعديلات جديدة على نطاق العمل المعتمد، أو الملاحظات الناتجة عن سوء الاستخدام، أو التداخلات البرمجية الناتجة عن أطراف خارجية.
        </p>
    </div>

    {{-- Section 6 --}}
    @if ($contract->non_compete === 'yes')
        <div class="section">
            <div class="section-title">
                المادة 6: شرط عدم المنافسة
            </div>

            <p class="clause">
                يتعهد المطور بعدم تقديم خدمات معلوماتية مماثلة أو تطوير حلول تقنية منافسة بشكل مباشر لنشاط الزبون داخل النفوذ الجغرافي لمدينة / منطقة:
                <strong>{{ $contract->compete_city }}</strong>،
                وذلك لمدة:
                <strong>
                    {{ $contract->compete_months }}
                    {{ $contract->compete_months == 1 ? 'شهر واحد' : ($contract->compete_months == 2 ? 'شهراً' : 'أشهر') }}
                </strong>
                سارية المفعول ابتداءً من تاريخ انقضاء هذا العقد أو إنهائه.
            </p>
        </div>
    @endif

    {{-- Section 7 --}}
    <div class="section">
        <div class="section-title">
            المادة 7: حماية المعطيات ذات الطابع الشخصي والسرية
        </div>

        <p class="clause">
            يتعهد الطرفان بالامتثال التام للتشريعات المغربية المتعلقة بحماية المعطيات الشخصية، ولا سيما أحكام <strong>القانون رقم 09-08</strong> المتعلق بحماية الأشخاص الذاتيين تجاه معالجة المعطيات ذات الطابع الشخصي، والتوجيهات الصادرة عن اللجنة الوطنية لمراقبة حماية المعطيات ذات الطابع الشخصي (CNDP).
        </p>

        <p class="clause">
            كما يلتزم الطرفان بالحفاظ على السرية التامة لكافة البيانات، الشفرات، والوثائق والأنظمة التقنية المتبادلة طوال فترة تنفيذ العقد وبعد انتهائه.
        </p>
    </div>

    {{-- Section 8 --}}
    <div class="section">
        <div class="section-title">
            المادة 8: أحكام عامة والقانون المطبق
        </div>

        <p class="clause">
            يخضع هذا العقد ويتحدد تفسيره وتنفيذه وفقاً للقانون المغربي. أي تعديل أو إضافة لبنود هذا العقد لا تُعتد بها إلا إذا كانت بموجب ملحق كتابي مؤرخ وموقع من كلا الطرفين.
        </p>

        <p class="clause">
            في حالة وقوع أي نزاع قد ينشأ عن تفسير أو تنفيذ هذا العقد، يسعى الطرفان أولاً للحل الودي، وفي حال تعذره يُحال النزاع إلى المحكمة التجارية المختصة مكانياً.
        </p>
    </div>

    {{-- Signatures --}}
    <div class="signature-wrapper">
        <table class="signature-table">
            <tr>
                <td>
                    <strong>توقيع المطور / المنفذ</strong>
                    <br>
                    <span style="font-size: 9pt; color: #64748b;">(مصحوب بعبارة "قرئ وصودق عليه")</span>
                    <div class="signature-line"></div>
                    <strong>{{ $contract->dev_name }}</strong>
                </td>
                <td>
                    <strong>توقيع الزبون</strong>
                    <br>
                    <span style="font-size: 9pt; color: #64748b;">(مصحوب بعبارة "قرئ وصودق عليه")</span>
                    <div class="signature-line"></div>
                    <strong>{{ $contract->client_name }}</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-notice">
        وثيقة عقد تقديم خدمات معلوماتية — تم إنشاؤها وتأطيرها وفقاً للقانون المغربي وحماية المعطيات CNDP.
    </div>
   <!-- Floating Action Toolbar (Hidden when printing) -->
<div class="no-print floating-toolbar" dir="rtl">
    <button onclick="window.print()" class="btn-print">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        طباعة المستند
    </button>

    <a href="{{ route('contracts.pdf', $contract->id) }}" class="btn-download">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
        تحميل كـ PDF
    </a>
</div>

<style>
    /* Floating Toolbar Container */
    .floating-toolbar {
        position: fixed;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%); /* Centers the toolbar perfectly */
        display: flex;
        gap: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        padding: 12px 20px;
        border-radius: 50px; /* Pill shape */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: 1px solid #e2e8f0;
        z-index: 9999;
        font-family: system-ui, -apple-system, sans-serif;
    }

    /* Shared Button Styles */
    .floating-toolbar button, 
    .floating-toolbar a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 30px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        line-height: 1;
    }

    /* Enforce strict sizes on SVGs to prevent the massive blue shape */
    .floating-toolbar svg {
        width: 20px !important;
        height: 20px !important;
        flex-shrink: 0;
    }

    /* Print Button */
    .btn-print {
        background-color: #f8fafc;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-print:hover {
        background-color: #e2e8f0;
        color: #0f172a;
        transform: translateY(-2px);
    }

    /* Download Button */
    .btn-download {
        background-color: #2563eb;
        color: #ffffff;
        border: 1px solid #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .btn-download:hover {
        background-color: #1d4ed8;
        transform: translateY(-2px);
    }

    /* Completely hide the toolbar during standard window.print() */
    @media print {
        .no-print, .floating-toolbar {
            display: none !important;
        }
    }
</style>
</body>
</html>