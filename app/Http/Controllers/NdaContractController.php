<?php

namespace App\Http\Controllers;

use App\Models\NdaContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF; // Uses Mpdf\Pdf via niklasravnsborg/laravel-pdf

class NdaContractController extends Controller
{
    // Show user's saved NDA contracts on the dashboard
    public function index()
    {
        $savedNdas = NdaContract::where('user_id', Auth::id())->latest()->get();
        return view('dashboard', compact('savedNdas'));
    }

    // Update preview method to return HTML View
    public function preview(NdaContract $ndaContract)
    {
        $this->authorizeUser($ndaContract);

        $data = $ndaContract->toArray();

        return view('nda_pdf', ['contract' => $ndaContract, 'data' => $data]);
    }

    // Show form to create new NDA contract
    public function create()
    {
        return view('nda_create');
    }

    // Validate & Save NDA contract to database
    public function store(Request $request)
    {
        $validated = $this->validateContract($request);

        $ndaContract = NdaContract::create([
            'user_id'          => Auth::id(),
            'project_name'     => $validated['project_name'],
            'disclosing_party' => $validated['disclosing_party'],
            'receiving_party'  => $validated['receiving_party'],
            'duration_years'   => $validated['duration_years'],
        ]);

        // If AJAX request, return JSON with preview & download URLs
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'contract_id'  => $ndaContract->id,
                'preview_url'  => route('nda.preview', $ndaContract->id),
                'download_url' => route('nda.pdf', $ndaContract->id),
            ]);
        }
        return redirect()->route('dashboard')->with('success', 'تم حفظ اتفاقية عدم الإفصاح بنجاح!');
    }

    // Show edit form
    public function edit(NdaContract $ndaContract)
    {
        $this->authorizeUser($ndaContract);
        return view('nda_edit', compact('ndaContract'));
    }

    // Update existing NDA contract
    public function update(Request $request, NdaContract $ndaContract)
    {
        $this->authorizeUser($ndaContract);
        $validated = $this->validateContract($request);

        $ndaContract->update($validated);

        return redirect()->route('dashboard')->with('success', 'تم تحديث اتفاقية عدم الإفصاح بنجاح!');
    }

    // Delete NDA contract
    public function destroy(NdaContract $ndaContract)
    {
        $this->authorizeUser($ndaContract);
        $ndaContract->delete();

        return redirect()->route('dashboard')->with('success', 'تم حذف اتفاقية عدم الإفصاح بنجاح.');
    }

    // Generate & Download PDF (Using mPDF native RTL configuration & arabic font)
    public function downloadPdf(NdaContract $ndaContract)
    {
        $this->authorizeUser($ndaContract);
        $data = $ndaContract->toArray();

        $config = [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'default_font'  => 'xbriyaz',
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 15,
            'margin_bottom' => 15,
        ];

        $pdf = PDF::loadView('nda_pdf', ['contract' => $ndaContract, 'data' => $data], [], $config);
        $filename = 'Contrat_NDA_' . preg_replace('/[^A-Za-z0-9_\-]/u', '_', $ndaContract->project_name) . '.pdf';

        return $pdf->download($filename);
    }

    // Helper validation method for NDA fields
    private function validateContract(Request $request)
    {
        return $request->validate([
            'project_name'     => ['required', 'string', 'max:255'],
            'disclosing_party' => ['required', 'string', 'max:255'],
            'receiving_party'  => ['required', 'string', 'max:255'],
            'duration_years'   => ['required', 'integer', 'min:1'],
        ]);
    }

    // Helper authorization check
    private function authorizeUser(NdaContract $ndaContract)
    {
        if ($ndaContract->user_id !== Auth::id()) {
            abort(403);
        }
    }
}