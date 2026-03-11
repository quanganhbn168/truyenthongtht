<?php

namespace App\Filament\Resources\Quotes\Tables;

use App\Models\Quote;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Quote $record): string => $record->phone),
                TextColumn::make('service.name')
                    ->label('Dịch vụ')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('budget_range')
                    ->label('Ngân sách')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'contacting' => 'warning',
                        'quoted' => 'info',
                        'closed' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Mới',
                        'contacting' => 'Đang liên hệ',
                        'quoted' => 'Đã báo giá',
                        'closed' => 'Hoàn tất',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'new' => 'Mới',
                        'contacting' => 'Đang liên hệ',
                        'quoted' => 'Đã báo giá',
                        'closed' => 'Hoàn tất/Hủy',
                    ]),
                SelectFilter::make('service_id')
                    ->label('Dịch vụ')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
