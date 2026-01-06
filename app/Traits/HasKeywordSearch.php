<?php

namespace App\Traits;

use App\Http\Controllers\Security\AESCipher;
use App\Models\AREInformation;
use App\Models\ICSInformation;

trait HasKeywordSearch
{
    protected function aes(): AESCipher
    {
        return app(AESCipher::class);
    }

    public function searchARE($query, $search, $year)
    {
        return $query->whereHas('information', function ($q) use ($year) {
                $q->where('dateAcquired', 'like', "{$year}%");
            })
            ->where(function ($q) use ($search) {
                $q->where('areControlNumber', 'like', "{$search}%")
                ->orWhere('receivedBy', 'like', "{$search}%")
                ->orWhereHas('information', function ($q) use ($search) {
                    $q->where('description', 'like', "{$search}%")
                      ->orWhere('propertyNumber', 'like', "{$search}%");  
                });
            })
            ->orderByDesc(
                AREInformation::select('dateAcquired')
                    ->whereColumn('are_information.are_id', 'are.id')
                    ->limit(1)
            );
    }


    public function searchICS($query, $search, $year)
    {
        return $query->whereHas('information', function ($q) use ($year) {
                $q->where('dateAcquired', 'like', "{$year}%");
            })
            ->where(function ($q) use ($search) {
                $q->where('icsNumber', 'like', "{$search}%")
                ->orWhere('receivedBy', 'like', "{$search}%")
                ->orWhereHas('information', function ($q) use ($search) {
                    $q->where('description', 'like', "{$search}%");
                });
            })
            ->orderByDesc(
                ICSInformation::select('dateAcquired')
                    ->whereColumn('ics_information.ics_id', 'ics.id')
                    ->limit(1)
            );
    }

    public function searchRPCPPE($query, $year, $office, $accountsCode)
    {

        return $query
    
        ->when(!empty($office), function ($q) use ($office) {
            $q->where('offices_id', $office);
        })

        ->whereHas('information', function ($infoQuery) use ($year, $accountsCode) {

            $infoQuery->whereYear('dateAcquired', $year);

            if (!empty($accountsCode)) {
                $infoQuery->where('account_codes_id', $accountsCode);
            }

        })
        ->orderByDesc(
            AREInformation::select('dateAcquired')
                ->whereColumn('are_information.are_id', 'are.id')
                ->limit(1)
        );

    }
}
