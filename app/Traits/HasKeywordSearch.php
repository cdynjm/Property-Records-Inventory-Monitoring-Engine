<?php

namespace App\Traits;

trait HasKeywordSearch
{
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
}
