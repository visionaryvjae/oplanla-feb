<?php

namespace App\Helpers;

class DateHelper
{
    public static function formatDays($totalDays, $showLabel = true)
    {
        $years = floor($totalDays / 365);
        $remainingDays = $totalDays % 365;
        $months = floor($remainingDays / 30);
        $days = $remainingDays % 30;

        $parts = [];
        
        if ($years > 0) {
            $parts[] = $years . ' ' . ($years === 1 ? 'year' : 'years');
        }
        
        if ($months > 0) {
            $parts[] = $months . ' ' . ($months === 1 ? 'month' : 'months');
        }
        
        if ($days > 0) {
            $parts[] = $days . ' ' . ($days === 1 ? 'day' : 'days');
        }

        if (empty($parts)) {
            return $showLabel ? '0 days' : '0d';
        }

        $result = implode(' ', $parts);
        
        return $showLabel ? $result : $result;
    }

    public static function formatDaysCompact($totalDays)
    {
        $years = floor($totalDays / 365);
        $months = floor(($totalDays % 365) / 30);
        $days = $totalDays % 30;
        
        $parts = [];
        if ($years > 0) $parts[] = $years . 'y';
        if ($months > 0) $parts[] = $months . 'm';
        if ($days > 0) $parts[] = $days . 'd';
        
        return empty($parts) ? '0d' : implode(' ', $parts);
    }
}