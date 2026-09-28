<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\NdaContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF; // Uses Mpdf\Pdf via niklasravnsborg/laravel-pdf

class ContractController extends Controller
{
    // Show user's saved contracts on the dashboard
    public function index()
{
    $savedContracts = Contract::where('user_id', Auth::id())->latest()->get();
    $savedNdas = NdaContract::where('user_id', Auth::id())->latest()->get();
    
    return view('dashboard', compact('savedContracts', 'savedNdas'));
}
    // Update preview method to return HTML View
public function previewPdf(Contract $contract)
{
    $this->authorizeUser($contract);
    
    $data = $contract->toArray();
    $data['non_compete_clause_number'] = ($data['non_compete'] === 'yes') ? 'البند الخامس' : null;
    $data['confidentiality_clause_number'] = ($data['non_compete'] === 'yes') ? 'البند السادس' : 'البند الخامس';

    // This renders your exact contract_pdf.blade.php as a web page
    return view('contract_pdf', ['contract' => $contract, 'data' => $data]);
}

    // Show form to create new contract
    public function create($type = 'prestation_it')
    {
        return view('contract_form', compact('type'));
    }

    // Validate & Save contract to database
    public function store(Request $request)
{
    $validated = $this->validateContract($request);

    $contract = Contract::create([
        'user_id'        => Auth::id(),
        'client_name'    => $validated['client_name'],
        'dev_name'       => $validated['dev_name'],
        'project_desc'   => $validated['project_desc'],
        'price'          => $validated['price'],
        'type'           => $request->input('type', 'it-service'),
        'ip_transfer'    => $validated['ip_transfer'],
        'support_months' => $validated['support_months'],
        'non_compete'    => $validated['non_compete'],
        'compete_city'   => $validated['compete_city'] ?? null,
        'compete_months' => $validated['compete_months'] ?? null,
    ]);

    // If AJAX request, return JSON with preview & download URLs
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success'      => true,
            'contract_id'  => $contract->id,
            'preview_url'  => route('contracts.preview', $contract->id),
            'download_url' => route('contracts.pdf', $contract->id),
        ]);
    }

    return redirect()->route('contracts.preview', $contract->id);
}

    // Show edit form
    public function edit(Contract $contract)
    {
        $this->authorizeUser($contract);
        return view('contract_edit', compact('contract'));
    }

    // Update existing contract
    public function update(Request $request, Contract $contract)
    {
        $this->authorizeUser($contract);
        $validated = $this->validateContract($request);

        $contract->update($validated);

        return redirect()->route('dashboard')->with('success', 'تم تحديث العقد بنجاح!');
    }

    // Delete contract
    public function destroy(Contract $contract)
    {
        $this->authorizeUser($contract);
        $contract->delete();

        return redirect()->route('dashboard')->with('success', 'تم حذف العقد بنجاح.');
    }

    // Generate & Download PDF (Using mPDF native RTL configuration)
    public function downloadPdf(Contract $contract)
    {
        $this->authorizeUser($contract);
        $data = $contract->toArray();

        // Clause numbering logic
        $data['non_compete_clause_number'] = ($data['non_compete'] === 'yes') ? 'البند الخامس' : null;
        $data['confidentiality_clause_number'] = ($data['non_compete'] === 'yes') ? 'البند السادس' : 'البند الخامس';

        $config = [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'default_font'  => 'xbriyaz',
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 15,
            'margin_bottom' => 15,
        ];

        $pdf = PDF::loadView('contract_pdf', ['contract' => $contract, 'data' => $data], [], $config);
        $filename = 'Contrat_IT_' . preg_replace('/[^A-Za-z0-9_\-]/u', '_', $contract->client_name) . '.pdf';

        return $pdf->download($filename);
    }

    // Helper validation method
    private function validateContract(Request $request)
    {
        $validated = $request->validate([
            'client_name'    => ['required', 'string', 'max:255'],
            'dev_name'       => ['required', 'string', 'max:255'],
            'project_desc'   => ['required', 'string'],
            'price'          => ['required', 'numeric', 'min:0'],
            'ip_transfer'    => ['required', 'in:yes,no'],
            'non_compete'    => ['required', 'in:yes,no'],
            'compete_city'   => ['nullable', 'string', 'max:255', 'required_if:non_compete,yes'],
            'compete_months' => ['nullable', 'integer', 'min:1', 'required_if:non_compete,yes'],
            'support_months' => ['required', 'integer', 'min:0'],
        ]);

        if ($validated['non_compete'] === 'no') {
            $validated['compete_city'] = null;
            $validated['compete_months'] = null;
        }

        return $validated;
    }

    // Helper authorization check
    private function authorizeUser(Contract $contract)
    {
        if ($contract->user_id !== Auth::id()) {
            abort(403);
        }
    }
}