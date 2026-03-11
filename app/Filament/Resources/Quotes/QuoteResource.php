<?php

namespace App\Filament\Resources\Quotes;

use App\Filament\Resources\Quotes\Pages\ManageQuotes;
use App\Models\Quote;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationGroup = 'Khách Hàng & Liên Hệ';

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
        return $schema
            ->components([
                Section::make('Thông tin khách hàng')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Họ và tên')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->required()
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('company_name')
                            ->label('Tên công ty')
                            ->maxLength(255),
                    ]),
                Section::make('Chi tiết yêu cầu')
                    ->columns(2)
                    ->schema([
                        Select::make('service_id')
                            ->label('Dịch vụ quan tâm')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('budget_range')
                            ->label('Ngân sách dự kiến')
                            ->options([
                                'Dưới 10 triệu' => 'Dưới 10 triệu',
                                '10 - 50 triệu' => '10 - 50 triệu',
                                '50 - 100 triệu' => '50 - 100 triệu',
                                'Trên 100 triệu' => 'Trên 100 triệu',
                                'Chưa xác định' => 'Chưa xác định',
                            ]),
                        Textarea::make('note')
                            ->label('Ghi chú / Yêu cầu chi tiết')
                            ->columnSpanFull()
                            ->rows(4),
                        Select::make('status')
                            ->label('Trạng thái xử lý')
                            ->options([
                                'new' => 'Mới',
                                'contacting' => 'Đang liên hệ',
                                'quoted' => 'Đã báo giá',
                                'closed' => 'Hoàn tất/Hủy',
                            ])
                            ->default('new')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
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
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageQuotes::route('/'),
        ];
    }
}
