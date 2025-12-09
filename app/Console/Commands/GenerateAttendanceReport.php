<?php

namespace App\Console\Commands;

use App\Services\AttendanceService;
use Illuminate\Console\Command;

class GenerateAttendanceReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:generate-report {month} {class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a monthly attendance report';

    /**
     * Execute the console command.
     */
    public function handle(AttendanceService $attendanceService)
    {
        $month = $this->argument('month');
        $class = $this->argument('class');

        $report = $attendanceService->getMonthlyReport($month, $class);

        if ($report->isEmpty()) {
            $this->info('No attendance records found for the given month and class.');

            return;
        }

        $this->table(
            ['Student Name', 'Date', 'Status', 'Note'],
            $report->map(function ($attendance) {
                return [
                    $attendance->student->name,
                    $attendance->date,
                    $attendance->status,
                    $attendance->note,
                ];
            })
        );
    }
}
