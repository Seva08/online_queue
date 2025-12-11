<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Queue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class QueueController extends Controller
{
    public function navQueue()
    {
        $nextQueues = Queue::with('user')->orderBy('created_at', 'asc')->get();
        $lastCalled = Cache::get('last_called_queue');

        return view('admin.navQueue', compact('nextQueues', 'lastCalled'));
    }

    public function getQueue()
    {
        $currentCount = Queue::count();
        
        if ($currentCount >= 5) {
            return redirect()->back()->with('error', 'Max Queue.');
        }

        $nextNumber = $currentCount + 1;
        $nextQueueNo = str_pad($nextNumber, 3, '0', STR_PAD_LEFT); // A001, A002, ..., A005

        return view('user.getQueue', compact('nextQueueNo', 'currentCount'));
    }

    public function listQueue()
    {
        $queues = Queue::with('user')->orderBy('created_at', 'asc')->get();
        return view('user.listQueue', compact('queues'));
    }

    public function takeNumber()
    {
        return redirect()->back()->with('success', 'Queue had taken.');
    }

    public function storeQueue(Request $request)
    {
        $userId = auth()->id() ?? 1;

        $currentCount = Queue::count();
        if ($currentCount >= 5) {
            return redirect()->back()->with('error', 'Max Queue.');
        }

        $nextNumber = $currentCount + 1;
        $queueNo = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Queue::create([
            'user_id' => $userId,
            'no' => $queueNo,
        ]);

        return redirect()->route('user.list-queue')->with('success', 'Your queue: ' . $queueNo);
    }

    public function callNext(Request $request)
    {
        $next = Queue::with('user')->orderBy('created_at', 'asc')->first();

        if (! $next) {
            return redirect()->back()->with('error', 'No queue');
        }

        $called = [
            'id' => $next->id,
            'no' => $next->no,
            'user_name' => $next->user->name ?? null,
            'called_at' => now()->toDateTimeString(),
        ];

        Cache::put('last_called_queue', $called, now()->addHours(6));

        $next->delete();

        return redirect()->back()->with('success', 'Memanggil antrian: ' . $called['no']);
    }

    public function index()
    {
        $queues = Queue::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.queue.index', compact('queues'));
    }

    public function create()
    {
        $currentCount = Queue::count();
        
        if ($currentCount >= 5) {
            return redirect()->route('queue.index')->with('error', 'Max Queue (max 5).');
        }

        $users = User::all();
        $nextNumber = $currentCount + 1;
        $nextQueueNo = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.queue.create', compact('users', 'nextQueueNo', 'currentCount'));
    }

    public function store(Request $request)
    {
        $currentCount = Queue::count();
        if ($currentCount >= 5) {
            return redirect()->route('queue.index')->with('error', 'Max queue.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $nextNumber = $currentCount + 1;
        $queueNo = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Queue::create([
            'user_id' => $validated['user_id'],
            'no' => $queueNo,
        ]);

        return redirect()->route('queue.index')->with('success', 'Queue added: ' . $queueNo);
    }

    public function edit(Queue $queue)
    {
        $users = User::all();
        return view('admin.queue.edit', compact('queue', 'users'));
    }

    public function update(Request $request, Queue $queue)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $queue->update($validated);

        return redirect()->route('queue.index')->with('success', 'User changed.');
    }

    public function destroy(Queue $queue)
    {
        $queue->delete();
        return redirect()->route('queue.index')->with('success', 'Queue deleted.');
    }
}
