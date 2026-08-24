<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Contacts\ContactResource;
use App\Models\Contact;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestContacts extends TableWidget
{
    protected static ?int $sort = 4;

    protected static ?string $heading = 'Liên hệ mới nhất';

    protected int|string|array $columnSpan = ['lg' => 1];

    public function table(Table $table): Table
    {
        return $table
            ->query(Contact::query()->latest('created_at')->limit(6))
            ->columns([
                TextColumn::make('name')
                    ->label('Người gửi')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('Tiêu đề')
                    ->limit(34)
                    ->placeholder('Không có tiêu đề'),
                IconColumn::make('is_read')
                    ->label('Đã đọc')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Gửi lúc')
                    ->since(),
            ])
            ->recordUrl(fn (Contact $record): string => ContactResource::getUrl('view', ['record' => $record]))
            ->paginated(false)
            ->emptyStateHeading('Chưa có liên hệ mới');
    }
}
