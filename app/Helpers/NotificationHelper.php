<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class NotificationHelper
{
    /**
     * Create notification for specific user
     */
    public static function create($userId, $message)
    {
        DB::table('notifikasis')->insert([
            'recipient_user_id' => $userId,
            'message' => $message,
            'is_read' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    
    /**
     * Create notification for all admins
     */
    public static function createForAllAdmins($message)
    {
        $adminIds = DB::table('users')
            ->where('role', 'admin')
            ->pluck('id');
        
        foreach ($adminIds as $adminId) {
            self::create($adminId, $message);
        }
    }
    
    /**
     * Notifikasi pembayaran baru
     */
    public static function newPayment($nominal, $pasienName)
    {
        $message = "💰 Pembayaran baru sebesar Rp " . number_format($nominal, 0, ',', '.') . " dari {$pasienName}";
        self::createForAllAdmins($message);
    }
    
    /**
     * Notifikasi jadwal konsultasi hari ini
     */
    public static function todaySchedule($count)
    {
        $message = "📅 Ada {$count} jadwal konsultasi hari ini";
        self::createForAllAdmins($message);
    }
    
    /**
     * Notifikasi komentar baru
     */
    public static function newComment($pasienName)
    {
        $message = "💬 Komentar baru dari {$pasienName}";
        self::createForAllAdmins($message);
    }
}