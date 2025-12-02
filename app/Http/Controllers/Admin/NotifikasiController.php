<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Get list notifikasi untuk user yang login
     */
    public function list()
    {
        $userId = Auth::id();
        
        $notifikasi = DB::table('notifikasis')
            ->where('recipient_user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(20)
            ->get();
        
        $unreadCount = DB::table('notifikasis')
            ->where('recipient_user_id', $userId)
            ->where('is_read', 0)
            ->count();
        
        return response()->json([
            'success' => true,
            'notifikasi' => $notifikasi,
            'unreadCount' => $unreadCount
        ]);
    }
    
    /**
     * Mark single notification as read
     */
    public function markAsRead($id)
    {
        DB::table('notifikasis')
            ->where('id', $id)
            ->where('recipient_user_id', Auth::id())
            ->update(['is_read' => 1]);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        DB::table('notifikasis')
            ->where('recipient_user_id', Auth::id())
            ->update(['is_read' => 1]);
        
        return response()->json(['success' => true]);
    }
}