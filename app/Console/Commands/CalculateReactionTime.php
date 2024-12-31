<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Cmixin\BusinessTime;

class CalculateReactionTime extends Command
{
    protected $signature = 'calculate:reactiontime';
    protected $description = 'Berechnet die Reaktionszeit innerhalb der Geschäftszeiten (Mo-Fr, 8-18 Uhr) unter Ausschluss der Feiertage.';

    public function handle()
    {
        $this->configureBusinessTime();

        $defaultStart = Carbon::now()->subDay()->format('d.m.y H:i');
        $defaultEnd = Carbon::now()->format('d.m.y H:i');

        $startTime = $this->askForValidTime('Geben Sie die Startzeit ein (Format: DD.MM.YY HH:mm)', $defaultStart);
        $endTime = $this->askForValidTime('Geben Sie die Endzeit ein (Format: DD.MM.YY HH:mm)', $defaultEnd);

        $reactionTimeMinutes = $this->calculateReactionTime($startTime, $endTime);

        $this->info("Die berechnete Reaktionszeit beträgt: " . $this->formatReactionTime($reactionTimeMinutes));
    }

    private function askForValidTime(string $question, string $default): Carbon
    {
        do {
            try {
                $input = $this->ask($question, $default);
                return Carbon::createFromFormat('d.m.y H:i', $input);
            } catch (\Exception $e) {
                $this->error("Ungültige Eingabe. Bitte verwenden Sie das Format DD.MM.YY HH:mm (z.B: {$default}).");
            }
        } while (true);
    }

    private function calculateReactionTime(Carbon $start, Carbon $end): int
    {
        $totalMinutes = 0;

        while ($start->lessThan($end)) {
            if ($start->isBusinessOpen()) {
                $totalMinutes++;
            }
            $start->addMinute();
        }

        return $totalMinutes;
    }

    private function formatReactionTime(int $minutes): string
    {
        if ($minutes < 60) {
            return "{$minutes} Minuten.";
        }

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        return $remainingMinutes > 0
            ? "{$hours} Stunden und {$remainingMinutes} Minuten."
            : "{$hours} Stunden.";
    }

    private function configureBusinessTime(): void
    {
        BusinessTime::enable(Carbon::class, [
            'monday'    => ['08:00-18:00'],
            'tuesday'   => ['08:00-18:00'],
            'wednesday' => ['08:00-18:00'],
            'thursday'  => ['08:00-18:00'],
            'friday'    => ['08:00-18:00'],
            'holidays'  => [
                'region' => 'de-national',
            ],
            'holidaysAreClosed' => true,
        ]);
    }
}

