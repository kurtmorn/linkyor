<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Web;

use App\Models\Clan;
use App\Models\Game;
use App\Models\Item;
use App\Models\User;
use App\Models\Report;
use App\Models\Status;
use App\Models\Message;
use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Models\ItemComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ReportsController;

class ReportController extends Controller
{
    public function index($type, $id)
    {
        $categories = ReportsController::REPORT_CATEGORIES_LONG;

        switch ($type) {
            case 'user':
                $content = User::where('username', '=', $id)->firstOrFail();

                if ($content->id == Auth::user()->id || $content->isBanned() || $content->isStaff()) abort(404);
                break;
            case 'status':
                $content = Status::where('id', '=', $id)->firstOrFail();

                if (!$content->message || $content->creator->id == Auth::user()->id || $content->creator->isStaff()) abort(404);
                break;
            case 'item':
                $content = Item::where('id', '=', $id)->firstOrFail();

                if ($content->creator->id == Auth::user()->id || $content->creator->isStaff()) abort(404);
                break;
            case 'comment':
                $content = ItemComment::where('id', '=', $id)->firstOrFail();

                if ($content->is_deleted || $content->creator->isStaff()) abort(404);
                break;
            case 'forumthread':
                $content = ForumThread::where('id', '=', $id)->firstOrFail();

                if ($content->creator->id == Auth::user()->id || $content->is_deleted || $content->creator->isStaff()) abort(404);
                break;
            case 'forumreply':
                $content = ForumReply::where('id', '=', $id)->firstOrFail();

                if ($content->creator->id == Auth::user()->id || $content->is_deleted || $content->creator->isStaff()) abort(404);
                break;
            case 'clan':
                $content = Clan::where('id', '=', $id)->firstOrFail();

                if ($content->owner->id == Auth::user()->id || $content->owner->isStaff()) abort(404);
                break;
            case 'set':
                $content = Game::where('id', '=', $id)->firstOrFail();

                if ($content->creator->id == Auth::user()->id || $content->creator->isStaff()) abort(404);
                break;
            case 'message':
                $content = Message::where('id', '=', $id)->firstOrFail();

                if ($content->sender->id == Auth::user()->id || $content->sender->isStaff() || $content->receiver->id != Auth::user()->id) abort(404);
                break;
            default:
                abort(404);
        }

        return view('web.report.index')->with([
            'id' => $id,
            'type' => $type,
            'categories' => $categories
        ]);
    }

    public function submit(Request $request)
    {
        switch ($request->type) {
            case 'user':
                $content = User::where('id', '=', $request->id)->firstOrFail();

                if ($content->id == Auth::user()->id || $content->isBanned() || $content->isStaff()) abort(404);
                break;
            case 'status':
                $content = Status::where('id', '=', $request->id)->firstOrFail();

                if (!$content->message || $content->creator->id == Auth::user()->id || $content->creator->isStaff()) abort(404);
                break;
            case 'item':
                $content = Item::where('id', '=', $request->id)->firstOrFail();

                if ($content->creator->id == Auth::user()->id || $content->creator->isStaff()) abort(404);
                break;
            case 'comment':
                $content = ItemComment::where('id', '=', $request->id)->firstOrFail();

                if ($content->is_deleted || $content->creator->isStaff()) abort(404);
                break;
            case 'forumthread':
                $content = ForumThread::where('id', '=', $request->id)->firstOrFail();

                if ($content->creator->id == Auth::user()->id || $content->is_deleted || $content->creator->isStaff()) abort(404);
                break;
            case 'forumreply':
                $content = ForumReply::where('id', '=', $request->id)->firstOrFail();

                if ($content->creator->id == Auth::user()->id || $content->is_deleted || $content->creator->isStaff()) abort(404);
                break;
            case 'clan':
                $content = Clan::where('id', '=', $request->id)->firstOrFail();

                if ($content->owner->id == Auth::user()->id || $content->is_locked || $content->owner->isStaff()) abort(404);
                break;
            case 'set':
                $content = Game::where('id', '=', $request->id)->firstOrFail();

                if ($content->creator->id == Auth::user()->id || $content->creator->isStaff()) abort(404);
                break;
            case 'message':
                $content = Message::where('id', '=', $request->id)->firstOrFail();

                if ($content->sender->id == Auth::user()->id || $content->sender->isStaff() || $content->receiver->id != Auth::user()->id) abort(404);
                break;
            default:
                abort(404);
        }

        $this->validate($request, [
            'comment' => ['max:250']
        ]);

        if (!in_array($request->category, ReportsController::REPORT_CATEGORIES))
            return back()->withErrors(['Invalid category.']);

        $report = new Report;
        $report->reporter_id = Auth::user()->id;
        $report->content_id = $content->id;
        $report->type = $request->type;
        $report->category = $request->category;
        $report->comment = $request->comment;
        $report->save();

        return redirect()->route('home.dashboard')->with('success_message', 'Your report has been successfully submitted.');
    }
}
