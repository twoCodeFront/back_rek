<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class InvoiceController extends Controller
{
    /**
     * Pobieramy listę faktur z paginacją na 10 el.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            return response()->json(
                Invoice::orderBy('issue_date', 'desc')->paginate($perPage)
            );

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Błąd podczas pobierania listy faktur.',
                'errors' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * tworzenie nowej faktury.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'invoice_number' => 'required|unique:invoices',
                'buyer_nip' => 'required|size:10',
                'seller_nip' => 'required|size:10',
                'product_name' => 'required',
                'product_price' => 'required|numeric|min:0',
                'issue_date' => 'required|date',
                'edit_date' => 'required|date',
            ]);

            $invoice = Invoice::create($validated);
            return response()->json($invoice, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Błąd walidacji',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Błąd serwera',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Aktualizacja faktury
     * @param Request $request
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function update(Request $request, Invoice $invoice): JsonResponse
    {
        try {
            $validated = $request->validate([
                'invoice_number' => 'required',
                'buyer_nip' => 'required|size:10',
                'seller_nip' => 'required|size:10',
                'product_name' => 'required',
                'product_price' => 'required|numeric|min:0',
                'issue_date' => 'required|date',
                'edit_date' => 'required|date',
            ]);

            $invoice->update($validated);
            return response()->json($invoice, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Błąd walidacji',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Błąd serwera',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Usunięcie faktury
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        try {
            $invoice->delete();
            return response()->json(['message' => 'Usunięto fakturę'], 204);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Błąd podczas usuwania faktury',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
