<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\NdaContract;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Saved user contracts and NDAs from database
        $savedContracts = Contract::where('user_id', $userId)->latest()->get();
        $savedNdas = NdaContract::where('user_id', $userId)->latest()->get();

        // قائمة العقود المتاحة مع التصنيفات والشروط
        $contracts = [
            [
                'id' => 'prestation_it',
                'title' => 'عقد تقديم خدمات معلوماتية',
                'category' => 'التقنية والبرمجة',
                'badge' => 'الأكثر طلباً',
                'description' => 'عقد متكامل لتطوير البرمجيات والمواقع مع خيارات نقل الملكية الفكرية وشروط عدم المنافسة.',
                'icon' => 'code',
                'active' => true,
                'create_url' => route('contracts.create') // Assuming you have a create route
            ],
            [
                'id' => 'nda',
                'title' => 'عقد عدم إفشاء الأسرار (NDA)',
                'category' => 'حماية البيانات والسرية',
                'badge' => 'أساسي',
                'description' => 'لحماية البيانات الحساسة والمشاريع قبل بدء التعاقد وفق قانون حماية المعطيات المغربي 09-08.',
                'icon' => 'shield',
                'active' => true,
                'create_url' => route('nda.create')
            ],
            [
                'id' => 'employment',
                'title' => 'عقد عمل فردي (CDD / CDI)',
                'category' => 'الموارد البشرية',
                'badge' => 'قريباً',
                'description' => 'مؤطر وفق مدونة الشغل المغربية مع تحديد فترة التجربة والتزامات الطرفين.',
                'icon' => 'users',
                'active' => false
            ],
            [
                'id' => 'commercial_lease',
                'title' => 'عقد كراء تجاري',
                'category' => 'العقارات والمحلات',
                'badge' => 'قريباً',
                'description' => 'محرر وفق القانون 49-16 المتعلق بكراء العقارات أو المحلات المخصصة للاستعمال التجاري.',
                'icon' => 'building',
                'active' => false
            ]
        ];

        return view('dashboard', compact('contracts', 'savedContracts', 'savedNdas'));
    }
}