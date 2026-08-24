<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Quotes\QuoteResource;
use App\Models\Quote;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestQuotes extends TableWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Yêu cầu báo giá gần đây';

    protected int|string|array $columnSpan = ['lg' => 1];

    public function table(Table $table): Table
    {
        return $table
            ->query(Quote::query()->with('service')->latest('created_at')->limit(6))
            ->columns([
                TextColumn::make('name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->description(fn (Quote $record): string => $record->phone),
                TextColumn::make('service.name')
                    ->label('Dịch vụ')
                    ->placeholder('Chưa chọn'),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Mới',
                        'contacting' => 'Đang liên hệ',
                        'quoted' => 'Đã báo giá',
                        'closed' => 'Hoàn tất',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'contacting' => 'warning',
                        'quoted' => 'info',
                        'closed' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Gửi lúc')
                    ->since(),
            ])
            ->recordUrl(fn (Quote $record): string => QuoteResource::getUrl('index') . '?tableSearch=' . urlencode($record->name))
            ->paginated(false)
            ->emptyStateHeading('Chưa có yêu cầu báo giá');
    }
}
