<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification; 


class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }


    public function destroy($id)
{
    $notification = Notification::findOrFail($id);
    $notification->delete();

    return redirect()->back()->with('success', 'Notification deleted successfully.');
}

    
}

