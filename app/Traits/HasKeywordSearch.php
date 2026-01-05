<?php

namespace App\Traits;

use App\Http\Controllers\Security\AESCipher;

trait HasKeywordSearch
{
    protected function aes(): AESCipher
    {
        return app(AESCipher::class);
    }

    public function searchARE($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('areControlNumber', 'like', "{$search}%")
              ->orWhere('receivedBy', 'like', "{$search}%")
              ->orWhereHas('information', function ($infoQuery) use ($search) {
                  $infoQuery->where('description', 'like', "{$search}%")
                        ->orWhere('propertyNumber', 'like', "{$search}%");
              });
        });
    }

    public function searchICS($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('icsNumber', 'like', "{$search}%")
              ->orWhere('receivedBy', 'like', "{$search}%")
              ->orWhereHas('information', function ($infoQuery) use ($search) {
                  $infoQuery->where('description', 'like', "{$search}%");
              });
        });
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

        });

    }
}
