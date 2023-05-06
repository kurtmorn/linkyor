<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public const REPORT_CATEGORIES = [
        'Profanity' => 'profanity',
        'Inappropriate' => 'inappropriate',
        'Requesting/Giving Private Info' => 'private_information',
        'Offsiting' => 'offsiting',
        'Harassment' => 'harassment',
        'Scamming' => 'scamming',
        'Stolen Account' => 'stolen_account',
        'Phishing/Hacking' => 'phishing',
        'Other' => 'other'
    ];

    public const REPORT_CATEGORIES_LONG = [
        'Excessive or inappropriate use of profanity' => 'profanity',
        'Inappropriate/adult content' => 'inappropriate',
        'Requesting or giving private information' => 'private_information',
        'Engaging in third party/offsite deals' => 'offsiting',
        'Harassing/bullying other users' => 'harassment',
        'Exploiting/scamming other users' => 'scamming',
        'Stolen account' => 'stolen_account',
        'Phishing/hacking/trading accounts' => 'phishing',
        'Other' => 'other'
    ];

    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!staffUser()->staff('can_review_pending_reports')) abort(404);

            return $next($request);
        });
    }

    public function index()
    {
        $reports = Report::where('is_seen', '=', false)->orderBy('created_at', 'DESC')->paginate(12);

        foreach ($reports as $report) {
            $report->category = array_search($report->category, $this::REPORT_CATEGORIES);

            if ($report->type == 'user')
                $report->reported_user_id = $report->content->id;
            else if ($report->content->creator_id)
                $report->reported_user_id = $report->content->creator_id;
            else if ($report->content->owner_id)
                $report->reported_user_id = $report->content->owner_id;
            else if ($report->content->user_id)
                $report->reported_user_id = $report->content->user_id;
            else if ($report->content->sender_id)
                $report->reported_user_id = $report->content->sender_id;
        }

        return view('admin.reports')->with([
            'reports' => $reports
        ]);
    }

    public function update(Request $request)
    {
        $report = Report::where('id', '=', $request->id)->firstOrFail();

        if ($report->is_seen)
            return back()->withErrors(['This report has already been dealt with.']);

        $report->reviewer_id = staffUser()->id;
        $report->is_seen = true;
        $report->save();

        return back()->with('success_message', 'Report has been marked as seen.');
    }
}
