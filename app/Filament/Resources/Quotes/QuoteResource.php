<?php

namespace App\Filament\Resources\Quotes;

use App\Filament\Resources\Quotes\Pages\ManageQuotes;
use App\Filament\Resources\Quotes\Schemas\QuoteForm;
use App\Filament\Resources\Quotes\Tables\QuotesTable;
use App\Models\Quote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Khách Hàng & Liên Hệ';

    protected static ?string $navigationLabel = 'Yêu Cầu Báo Giá';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return 'Yêu cầu báo giá';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Yêu cầu báo giá';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return QuoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuotesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageQuotes::route('/'),
        ];
    }
}
