<?php

namespace App\Filament\Resources\Contacts;

use App\Filament\Resources\Contacts\Pages\CreateContact;
use App\Filament\Resources\Contacts\Pages\EditContact;
use App\Filament\Resources\Contacts\Pages\ListContacts;
use App\Filament\Resources\Contacts\Pages\ViewContact;
use App\Filament\Resources\Contacts\Schemas\ContactForm;
use App\Filament\Resources\Contacts\Tables\ContactsTable;
use App\Models\Contact;
use BackedEnum;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $navigationLabel = 'Liên hệ';

    protected static ?string $modelLabel = 'Liên hệ';

    protected static ?string $pluralModelLabel = 'Liên hệ';

    protected static string|UnitEnum|null $navigationGroup = 'Quản lý';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ContactForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Thông tin liên hệ')
                ->schema([
                    TextEntry::make('name')->label('Họ tên'),
                    TextEntry::make('email')->label('Email'),
                    TextEntry::make('phone')->label('Số điện thoại'),
                    TextEntry::make('subject')->label('Tiêu đề')->columnSpanFull(),
                    TextEntry::make('message')->label('Nội dung')->columnSpanFull(),
                    IconEntry::make('is_read')->label('Đã đọc')->boolean(),
                    TextEntry::make('created_at')->label('Ngày gửi')->dateTime('d/m/Y H:i'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ContactsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'view'   => ViewContact::route('/{record}'),
            'edit'   => EditContact::route('/{record}/edit'),
        ];
    }
}
