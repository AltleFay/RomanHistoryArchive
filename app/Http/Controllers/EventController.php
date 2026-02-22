<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index() {
        $events = Event::with('era')->orderBy('start_year', 'asc')->get();
        
        return view('timeline', compact('events')); 
    }
}