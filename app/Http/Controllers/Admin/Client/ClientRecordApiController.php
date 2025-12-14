<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientRecordApiController extends Controller
{
    /**
     * Update client data
     */
    public function updateClient(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'first_last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255',
            'email' => ['required', 'email', Rule::unique('client')->ignore($id)],
            'client_type_id' => 'required|exists:component_option,id',
            'document_type_id' => 'required|exists:component_option,id',
            'document_number' => ['required', 'string', Rule::unique('client')->ignore($id)],
            'phone' => 'required|string',
            'IBAN' => 'nullable|string',
            'user_title_id' => 'nullable|exists:component_option,id',
            'country_id' => 'required|exists:country,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $client = Client::findOrFail($id);
            $client->update($request->only([
                'name',
                'first_last_name',
                'second_last_name',
                'email',
                'client_type_id',
                'document_type_id',
                'document_number',
                'phone',
                'IBAN',
                'user_title_id',
                'country_id'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Cliente actualizado correctamente',
                'client' => $client->load(['clientType', 'documentType', 'title', 'country'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cliente: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update address data
     */
    public function updateAddress(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:location,id',
            'street_type_id' => 'required|exists:component_option,id',
            'housing_type_id' => 'required|exists:component_option,id',
            'street_name' => 'required|string|max:255',
            'street_number' => 'required|string|max:50',
            'zip_code' => 'required|string|spanish_postal_code',
            'block' => 'nullable|string|max:50',
            'block_staircase' => 'nullable|string|max:50',
            'floor' => 'nullable|string|max:50',
            'door' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $address = Address::findOrFail($id);
            $address->update($request->only([
                'location_id',
                'street_type_id',
                'housing_type_id',
                'street_name',
                'street_number',
                'zip_code',
                'block',
                'block_staircase',
                'floor',
                'door'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Dirección actualizada correctamente',
                'address' => $address->load(['location.province', 'streetType', 'housingType'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la dirección: ' . $e->getMessage()
            ], 500);
        }
    }
}
