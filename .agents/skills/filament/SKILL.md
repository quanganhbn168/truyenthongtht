---
name: Filament 5 Reference
description: Tài liệu tham chiếu Filament 5 — cấu trúc Resource, namespace, Schema, Table, Action, Layout, Infolist.
---

# Filament 5 Reference — Dự án erptht

> [!CAUTION]
> **KHÔNG dùng FQCN (Fully Qualified Class Name) trong code.** Luôn khai báo `use` ở đầu file rồi gọi tên ngắn.

---

## 1. Namespace Map (Quan trọng nhất)

Filament 5 tách hoàn toàn các package. Namespace khác biệt lớn so với v3/v4.

### 1.1 Schema & Layout Components

| Class | Namespace |
|---|---|
| `Schema` | `Filament\Schemas\Schema` |
| `Section` | `Filament\Schemas\Components\Section` |
| `Tabs` | `Filament\Schemas\Components\Tabs` |
| `Tab` | `Filament\Schemas\Components\Tabs\Tab` |
| `Grid` | `Filament\Schemas\Components\Grid` |
| `Fieldset` | `Filament\Schemas\Components\Fieldset` |
| `Flex` | `Filament\Schemas\Components\Flex` |
| `Group` | `Filament\Schemas\Components\Group` |
| `Wizard` | `Filament\Schemas\Components\Wizard` |
| `Wizard\Step` | `Filament\Schemas\Components\Wizard\Step` |
| `Component` (base) | `Filament\Schemas\Components\Component` |

> [!WARNING]
> Trong Filament 5, **Section, Tabs, Grid, Fieldset, Wizard, Group** đều nằm trong `Filament\Schemas\Components\*`.
> **KHÔNG PHẢI** `Filament\Forms\Components\Section` hay `Filament\Infolists\Components\Section` nữa.

### 1.2 Form Fields (Input Components)

| Class | Namespace |
|---|---|
| `TextInput` | `Filament\Forms\Components\TextInput` |
| `Textarea` | `Filament\Forms\Components\Textarea` |
| `Select` | `Filament\Forms\Components\Select` |
| `Toggle` | `Filament\Forms\Components\Toggle` |
| `Checkbox` | `Filament\Forms\Components\Checkbox` |
| `CheckboxList` | `Filament\Forms\Components\CheckboxList` |
| `Radio` | `Filament\Forms\Components\Radio` |
| `DateTimePicker` | `Filament\Forms\Components\DateTimePicker` |
| `DatePicker` | `Filament\Forms\Components\DatePicker` |
| `TimePicker` | `Filament\Forms\Components\TimePicker` |
| `FileUpload` | `Filament\Forms\Components\FileUpload` |
| `RichEditor` | `Filament\Forms\Components\RichEditor` |
| `MarkdownEditor` | `Filament\Forms\Components\MarkdownEditor` |
| `ColorPicker` | `Filament\Forms\Components\ColorPicker` |
| `TagsInput` | `Filament\Forms\Components\TagsInput` |
| `KeyValue` | `Filament\Forms\Components\KeyValue` |
| `Repeater` | `Filament\Forms\Components\Repeater` |
| `Builder` | `Filament\Forms\Components\Builder` |
| `Hidden` | `Filament\Forms\Components\Hidden` |
| `Placeholder` | `Filament\Forms\Components\Placeholder` |
| `ToggleButtons` | `Filament\Forms\Components\ToggleButtons` |
| `Slider` | `Filament\Forms\Components\Slider` |
| `OneTimeCodeInput` | `Filament\Forms\Components\OneTimeCodeInput` |
| `MorphToSelect` | `Filament\Forms\Components\MorphToSelect` |
| `Field` (base) | `Filament\Forms\Components\Field` |

> [!IMPORTANT]
> Layout components (Section, Tabs, Grid...) nằm ở `Filament\Schemas\Components\*`.
> Form fields (TextInput, Select, Toggle...) vẫn nằm ở `Filament\Forms\Components\*`.

### 1.3 Table Components

| Class | Namespace |
|---|---|
| `Table` | `Filament\Tables\Table` |
| `TextColumn` | `Filament\Tables\Columns\TextColumn` |
| `ImageColumn` | `Filament\Tables\Columns\ImageColumn` |
| `IconColumn` | `Filament\Tables\Columns\IconColumn` |
| `BooleanColumn` | `Filament\Tables\Columns\BooleanColumn` |
| `SelectColumn` | `Filament\Tables\Columns\SelectColumn` |
| `CheckboxColumn` | `Filament\Tables\Columns\CheckboxColumn` |
| `TextInputColumn` | `Filament\Tables\Columns\TextInputColumn` |
| `ToggleColumn` | `Filament\Tables\Columns\ToggleColumn` |
| `ColorColumn` | `Filament\Tables\Columns\ColorColumn` |
| `Column` (base) | `Filament\Tables\Columns\Column` |

### 1.4 Table Filters

| Class | Namespace |
|---|---|
| `SelectFilter` | `Filament\Tables\Filters\SelectFilter` |
| `Filter` | `Filament\Tables\Filters\Filter` |
| `TernaryFilter` | `Filament\Tables\Filters\TernaryFilter` |
| `TrashedFilter` | `Filament\Tables\Filters\TrashedFilter` |
| `QueryBuilder` | `Filament\Tables\Filters\QueryBuilder` |

### 1.5 Actions (Unified Package)

| Class | Namespace |
|---|---|
| `Action` | `Filament\Actions\Action` |
| `CreateAction` | `Filament\Actions\CreateAction` |
| `EditAction` | `Filament\Actions\EditAction` |
| `DeleteAction` | `Filament\Actions\DeleteAction` |
| `ViewAction` | `Filament\Actions\ViewAction` |
| `ReplicateAction` | `Filament\Actions\ReplicateAction` |
| `ForceDeleteAction` | `Filament\Actions\ForceDeleteAction` |
| `RestoreAction` | `Filament\Actions\RestoreAction` |
| `ImportAction` | `Filament\Actions\ImportAction` |
| `ExportAction` | `Filament\Actions\ExportAction` |
| `ActionGroup` | `Filament\Actions\ActionGroup` |
| `BulkAction` | `Filament\Actions\BulkAction` |
| `BulkActionGroup` | `Filament\Actions\BulkActionGroup` |
| `DeleteBulkAction` | `Filament\Actions\DeleteBulkAction` |

> [!WARNING]
> Trong Filament 5, **TẤT CẢ Action** đều nằm trong `Filament\Actions\*`.
> **KHÔNG CÒN** `Filament\Tables\Actions\EditAction`, `Filament\Tables\Actions\DeleteAction` riêng nữa.
> Tuy nhiên khi dùng **prefix import** `use Filament\Tables;` thì gọi `Tables\Actions\EditAction`
> vẫn hoạt động được vì Filament tự alias. Nhưng cách chuẩn nhất là import từ `Filament\Actions\*`.

### 1.6 Infolist Entries

| Class | Namespace |
|---|---|
| `TextEntry` | `Filament\Infolists\Components\TextEntry` |
| `ImageEntry` | `Filament\Infolists\Components\ImageEntry` |
| `IconEntry` | `Filament\Infolists\Components\IconEntry` |
| `ColorEntry` | `Filament\Infolists\Components\ColorEntry` |
| `KeyValueEntry` | `Filament\Infolists\Components\KeyValueEntry` |
| `RepeatableEntry` | `Filament\Infolists\Components\RepeatableEntry` |

> [!NOTE]
> Infolist dùng chung layout components từ `Filament\Schemas\Components\*` (Section, Tabs, Grid).

### 1.7 Notifications

| Class | Namespace |
|---|---|
| `Notification` | `Filament\Notifications\Notification` |

### 1.8 Resource & Pages

| Class | Namespace | Ghi chú |
|---|---|---|
| `Resource` | `Filament\Resources\Resource` | Base cho CRUD resources |
| `Page` (resource) | `Filament\Resources\Pages\Page` | Base cho resource pages |
| `Page` (custom) | `Filament\Pages\Page` | Base cho custom pages (report, dashboard) |
| `ListRecords` | `Filament\Resources\Pages\ListRecords` | |
| `CreateRecord` | `Filament\Resources\Pages\CreateRecord` | |
| `EditRecord` | `Filament\Resources\Pages\EditRecord` | |
| `ViewRecord` | `Filament\Resources\Pages\ViewRecord` | |
| `ManageRecords` | `Filament\Resources\Pages\ManageRecords` | |
| `RelationManager` | `Filament\Resources\RelationManagers\RelationManager` | |

> [!CAUTION]
> **Custom Pages** (như report, dashboard) dùng `Filament\Pages\Page`.
> **Resource Pages** (List, Create, Edit) dùng `Filament\Resources\Pages\*`.
> Hai class `Page` này **KHÁC NHAU**, không nhầm lẫn!

---

## 2. Cấu trúc Resource (Project Convention)

Filament 5 đặt Resource bên trong thư mục group (số nhiều):

```
app/Filament/Resources/
└── {Models}/
    ├── {Model}Resource.php                      ← Resource chính
    ├── Pages/
    │   ├── List{Models}.php                     ← extends ListRecords
    │   ├── Create{Model}.php                    ← extends CreateRecord
    │   └── Edit{Model}.php                      ← extends EditRecord
    ├── Schemas/
    │   └── {Model}Form.php                      ← Form schema class
    └── Tables/
        └── {Models}Table.php                    ← Table config class
```

> [!IMPORTANT]
> Namespace là `App\Filament\Resources\{Models}`, **KHÔNG PHẢI** `App\Filament\Resources`.

### 2.1 Resource chính (`{Model}Resource.php`)

```php
<?php

namespace App\Filament\Resources\{Models};

use App\Filament\Resources\{Models}\Pages\Create{Model};
use App\Filament\Resources\{Models}\Pages\Edit{Model};
use App\Filament\Resources\{Models}\Pages\List{Models};
use App\Filament\Resources\{Models}\Schemas\{Model}Form;
use App\Filament\Resources\{Models}\Tables\{Models}Table;
use App\Models\{Model};
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class {Model}Resource extends Resource
{
    protected static ?string $model = {Model}::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedXxx;

    protected static ?string $navigationLabel = 'Tên hiển thị';

    protected static ?string $modelLabel = 'Tên đơn';

    protected static ?string $pluralModelLabel = 'Tên số nhiều';

    protected static string|UnitEnum|null $navigationGroup = 'Nhóm menu';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return {Model}Form::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return {Models}Table::configure($table);
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
            'index' => List{Models}::route('/'),
            'create' => Create{Model}::route('/create'),
            'edit' => Edit{Model}::route('/{record}/edit'),
        ];
    }
}
```

> [!IMPORTANT]
> Method `form()` nhận và trả về `Schema $schema` (từ `Filament\Schemas\Schema`), **KHÔNG PHẢI** `Form $form`.
> Method `infolist()` cũng nhận `Schema $schema`, **KHÔNG PHẢI** `Infolist $infolist`.

### 2.2 Form Schema (`Schemas/{Model}Form.php`)

```php
<?php

namespace App\Filament\Resources\{Models}\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class {Model}Form
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tiêu đề section')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên')
                            ->required()
                            ->maxLength(255),
                        Select::make('category_id')
                            ->label('Danh mục')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Toggle::make('is_active')
                            ->label('Hoạt động')
                            ->default(true),
                        Textarea::make('description')
                            ->label('Mô tả')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
```

> [!NOTE]
> Section dùng `->schema([...])` để khai báo nội dung bên trong.
> Schema root dùng `->components([...])`.

### 2.3 Table Config (`Tables/{Models}Table.php`)

Có 2 cách import table components:

```php
<?php

namespace App\Filament\Resources\{Models}\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class {Models}Table
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'active' => 'Hoạt động',
                        'inactive' => 'Ngưng',
                    ]),
            ])
            ->actions([                           // alias: ->recordActions()
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([                         // alias: ->toolbarActions()
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

> [!NOTE]
> Filament 5 có **2 cách gọi**, cả hai đều hợp lệ:
> - `->actions()` = `->recordActions()` (hiện action trên mỗi row)
> - `->bulkActions()` = `->toolbarActions()` (hiện bulk action trên toolbar)
> Cách phổ biến nhất: `->actions()` và `->bulkActions()`.

### 2.4 Page classes

```php
<?php
// ListRecords page
namespace App\Filament\Resources\{Models}\Pages;

use App\Filament\Resources\{Models}\{Model}Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class List{Models} extends ListRecords
{
    protected static string $resource = {Model}Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Thêm mới'),
        ];
    }
}
```

```php
<?php
// CreateRecord page
namespace App\Filament\Resources\{Models}\Pages;

use App\Filament\Resources\{Models}\{Model}Resource;
use Filament\Resources\Pages\CreateRecord;

class Create{Model} extends CreateRecord
{
    protected static string $resource = {Model}Resource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
```

```php
<?php
// EditRecord page
namespace App\Filament\Resources\{Models}\Pages;

use App\Filament\Resources\{Models}\{Model}Resource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class Edit{Model} extends EditRecord
{
    protected static string $resource = {Model}Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
```

---

## 3. Layout Components — Cách dùng

Tất cả layout components thuộc `Filament\Schemas\Components\*`.

### Section
```php
use Filament\Schemas\Components\Section;

Section::make('Thông tin chung')
    ->description('Mô tả section')
    ->icon('heroicon-o-information-circle')
    ->schema([
        // form fields ở đây
    ])
    ->columns(2)
    ->collapsible()
    ->collapsed(false)
    ->aside()           // hiển thị dạng aside (label bên trái, form bên phải)
    ->compact()         // giảm padding
    ->headerActions([   // actions trên header của section
        Action::make('loadDefaults')->label('Tải mặc định'),
    ]);
```

### Tabs
```php
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

Tabs::make('Tabs label')
    ->tabs([
        Tab::make('Tab 1')
            ->icon('heroicon-o-user')
            ->badge(5)
            ->schema([
                // components
            ]),
        Tab::make('Tab 2')
            ->schema([
                // components
            ]),
    ])
    ->persistTabInQueryString('tab')   // lưu tab active vào URL
    ->contained(false);                // bỏ border container
```

### Grid
```php
use Filament\Schemas\Components\Grid;

Grid::make(3)   // 3 columns
    ->schema([
        // components
    ]);
```

### Fieldset
```php
use Filament\Schemas\Components\Fieldset;

Fieldset::make('Địa chỉ')
    ->schema([
        // components
    ])
    ->columns(2);
```

### Wizard
```php
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;

Wizard::make([
    Step::make('Bước 1')
        ->icon('heroicon-o-user')
        ->schema([...]),
    Step::make('Bước 2')
        ->schema([...]),
]);
```

---

## 4. Actions — Các lưu ý

### 4.1 Tất cả Action từ `Filament\Actions\*`

```php
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
```

### 4.2 Actions trong Header Pages

```php
use Filament\Actions;

// Trong Page class
protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make(),
        Actions\DeleteAction::make(),
    ];
}
```

### 4.3 Action modal với form

```php
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

Action::make('doSomething')
    ->label('Thực hiện')
    ->icon('heroicon-o-plus')
    ->color('primary')
    ->schema([           // Filament 5 dùng ->schema() thay vì ->form()
        Section::make()
            ->schema([
                TextInput::make('name')->required(),
            ]),
    ])
    ->action(function (array $data) {
        // xử lý
    })
    ->requiresConfirmation()        // hỏi xác nhận trước khi thực hiện
    ->modalHeading('Tiêu đề modal')
    ->modalDescription('Mô tả')
    ->modalSubmitActionLabel('Xác nhận')
    ->slideOver();                   // hiện dạng drawer
```

### 4.4 Section headerActions

```php
use Filament\Actions\Action;
use Filament\Schemas\Components\Section;

Section::make('Thông tin')
    ->headerActions([
        Action::make('refresh')
            ->label('Làm mới')
            ->icon('heroicon-o-arrow-path')
            ->action(fn () => /* ... */),
    ])
    ->schema([...]);
```

---

## 5. Notification

```php
use Filament\Notifications\Notification;

Notification::make()
    ->title('Thành công!')
    ->body('Đã lưu dữ liệu.')
    ->success()     // hoặc ->danger(), ->warning(), ->info()
    ->send();
```

---

## 6. Checklist khi tạo Resource mới

1. Tạo Model + Migration
2. Tạo Resource: `{Model}Resource.php`
3. Tạo thư mục con:
   - `{Model}Resource/Pages/` — List, Create, Edit
   - `{Model}Resource/Schemas/` — `{Model}Form.php`
   - `{Model}Resource/Tables/` — `{Models}Table.php`
4. Kiểm tra namespace:
   - [ ] `Schema` from `Filament\Schemas\Schema`
   - [ ] Layout (Section, Tabs, Grid) from `Filament\Schemas\Components\*`
   - [ ] Form fields from `Filament\Forms\Components\*`
   - [ ] Table from `Filament\Tables\Table`
   - [ ] Columns from `Filament\Tables\Columns\*`
   - [ ] Filters from `Filament\Tables\Filters\*`
   - [ ] Actions from `Filament\Actions\*`
   - [ ] Notifications from `Filament\Notifications\Notification`
5. Không dùng FQCN trong code body

---

## 7. Sai lầm thường gặp

| ❌ SAI | ✅ ĐÚNG |
|---|---|
| `namespace App\Filament\Resources` | `namespace App\Filament\Resources\{Models}` |
| `Resources/{Model}Resource.php` (ngoài) | `Resources/{Models}/{Model}Resource.php` (trong) |
| `protected static ?string $navigationGroup` | `protected static string\|UnitEnum\|null $navigationGroup` |
| `->actions([...])` trong Table | ✅ OK — alias cho `->recordActions([...])` |
| `->bulkActions([...])` trong Table | ✅ OK — alias cho `->toolbarActions([...])` |
| `use Filament\Forms\Components\Section` | `use Filament\Schemas\Components\Section` |
| `use Filament\Forms\Components\Tabs` | `use Filament\Schemas\Components\Tabs` |
| `public static function form(Form $form)` | `public static function form(Schema $schema)` |
| `$form->schema([...])` | `$schema->components([...])` |
| `use Filament\Tables\Actions\EditAction` | `use Filament\Actions\EditAction` |
| `->form([...])` trong Action | `->schema([...])` trong Action |
| `Pages\List{Models}::route('/')` | `List{Models}::route('/')` (import trực tiếp) |
| `Repeater::headerActions([...])` | Dùng Section bọc ngoài + `->headerActions([...])` |
| `protected static string $view` (Page) | `protected string $view` (KHÔNG có `static`) |
| `use Filament\Resources\Pages\Page` (custom) | `use Filament\Pages\Page` (custom page) |
| `->size(TextEntry\TextEntrySize::Large)` | ❌ `TextEntrySize` không tồn tại — bỏ hoặc dùng `->size('lg')` |
| `public function infolist(Infolist $infolist)` | `public function infolist(Schema $schema)` |
| `protected static ?string $heading` (Widget) | `protected ?string $heading` (KHÔNG có `static`) |
| `protected static ?string $maxHeight` (Chart) | `protected ?string $maxHeight` (KHÔNG có `static`) |
| `protected static string $view` (Widget) | `protected string $view` (KHÔNG có `static`) |
| `<x-filament::icon icon="..." class="w-8 h-8">` | `<x-filament::icon icon="..." :size="IconSize::Large">` (dùng prop size) |

---

## 8. Icon Rendering trong Blade Views

Filament 5 có Blade component `<x-filament::icon>` (file: `vendor/filament/support/resources/views/components/icon.blade.php`).
Bên trong nó gọi `generate_icon_html()` và áp dụng CSS class `fi-icon fi-size-{size}`.

### 8.1 Cách dùng đúng

```blade
@php
    use Filament\Support\Enums\IconSize;
@endphp

{{-- Cách 1: Kích thước mặc định (Medium) --}}
<x-filament::icon icon="heroicon-o-user" />

{{-- Cách 2: Chọn kích thước qua prop --}}
<x-filament::icon icon="heroicon-o-cog" :size="IconSize::Small" />
<x-filament::icon icon="heroicon-o-cog" :size="IconSize::Large" />

{{-- Cách 3: Thêm class cho màu sắc --}}
<div class="text-emerald-500">
    <x-filament::icon icon="heroicon-o-check" :size="IconSize::Medium" />
</div>
```

### 8.2 Component Props

| Prop | Type | Mô tả |
|------|------|--------|
| `icon` | `string` | Tên icon (VD: `heroicon-o-user`) |
| `alias` | `?string` | Filament icon alias |
| `size` | `?IconSize` | Enum control kích thước |

### 8.3 IconSize Enum (`Filament\Support\Enums\IconSize`)

| Enum | Value |
|------|-------|
| `IconSize::ExtraSmall` | `xs` |
| `IconSize::Small` | `sm` |
| `IconSize::Medium` | `md` |
| `IconSize::Large` | `lg` |
| `IconSize::ExtraLarge` | `xl` |
| `IconSize::TwoExtraLarge` | `2xl` |

> [!CAUTION]
> **KHÔNG dùng Tailwind class** (`w-5 h-5`, `w-8 h-8`) để control kích thước icon trong Filament views.
> Filament CSS sẽ override → icon bị khổng lồ hoặc sai size.
> **LUÔN dùng** prop `:size="IconSize::Large"` để Filament quản lý kích thước qua class `fi-size-*`.

---

## 9. Quick Reference — Import thường dùng

```php
// Schema & Layout
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Fieldset;

// Form Fields
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\ToggleButtons;

// Table
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;

// Actions
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

// Infolist
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;

// Notifications
use Filament\Notifications\Notification;

// Resource & Pages
use Filament\Resources\Resource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;

// Custom Pages (non-resource)
use Filament\Pages\Page;  // ← KHÁC với Filament\Resources\Pages\Page
```

---

## 9. Custom Pages (Non-resource Pages)

Custom Pages dùng cho report, dashboard, settings — KHÔNG gắn với model CRUD.

### 9.1 Cấu trúc thư mục

```
app/Filament/{Panel}/Pages/
├── RevenueReport.php         ← PHP class extends Page
├── CourtUtilization.php
└── PopularTimeSlots.php

resources/views/filament/{panel}/pages/
├── revenue-report.blade.php  ← Blade view
├── court-utilization.blade.php
└── popular-time-slots.blade.php
```

### 9.2 Custom Page class

```php
<?php

namespace App\Filament\Tenant\Pages;

use BackedEnum;
use Filament\Pages\Page;   // ← KHÔNG PHẢI Filament\Resources\Pages\Page
use UnitEnum;

class RevenueReport extends Page
{
    // ⚠️ Các property type PHẢI khớp với parent Page
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Báo cáo doanh thu';

    protected static ?string $title = 'Báo cáo doanh thu';

    protected static string|UnitEnum|null $navigationGroup = 'Báo cáo';

    protected static ?int $navigationSort = 1;

    // ⚠️ QUAN TRỌNG: $view là NON-STATIC (không có static)
    protected string $view = 'filament.tenant.pages.revenue-report';

    // Livewire properties cho filter
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    public function mount(): void
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    // Business logic methods — gọi từ Blade
    public function getReportData(): array
    {
        // query data...
        return [];
    }
}
```

> [!CAUTION]
> `protected string $view` — **KHÔNG CÓ `static`**!
> Parent `Filament\Pages\BasePage` khai báo `protected string $view;` (non-static).
> Nếu thêm `static` sẽ gây lỗi: **"Cannot redeclare non static property"**.

> [!WARNING]
> Trong Filament 5, property types trên Custom Page **PHẢI KHỚP CHÍNH XÁC** với parent:
> - `$navigationIcon` → `string|BackedEnum|null` (cần `use BackedEnum;`)
> - `$navigationGroup` → `string|UnitEnum|null` (cần `use UnitEnum;`)
> - `$view` → `string` (non-static, KHÔNG nullable)

### 9.3 Panel Registration

Custom Pages tự động được scan nếu cấu hình `discoverPages()` trong PanelProvider:

```php
// TenantPanelProvider.php
->discoverPages(
    in: app_path('Filament/Tenant/Pages'),
    for: 'App\\Filament\\Tenant\\Pages'
)
```

---

## 10. Custom Blade Views cho Pages

### 10.1 View naming convention

View path theo cấu trúc:
```
resources/views/filament/{panel}/pages/{kebab-case-name}.blade.php
```

Ví dụ:
- `RevenueReport` → `filament.tenant.pages.revenue-report`
- `CourtUtilization` → `filament.tenant.pages.court-utilization`

### 10.2 Blade view template

```blade
<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Filter section --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Từ ngày</label>
                    <input type="date" wire:model.live="dateFrom" class="mt-1 block rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 text-sm">
                </div>
            </div>
        </div>

        @php $data = $this->getReportData(); @endphp

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Label</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ number_format($data['value']) }}</p>
            </div>
        </div>
    </div>
</x-filament-panels::page>
```

> [!IMPORTANT]
> - Luôn bọc trong `<x-filament-panels::page>` để có header/breadcrumb Filament.
> - Dùng `fi-section` class để match style Filament native.
> - Dùng `wire:model.live` cho Livewire reactive bindings.
> - Support dark mode bằng `dark:` prefix.

### 10.3 CSS Classes thường dùng trong Filament views

| Class | Mô tả |
|---|---|
| `fi-section` | Section container style |
| `rounded-xl` | Bo góc lớn |
| `bg-white dark:bg-gray-900` | Nền trắng/dark |
| `shadow-sm` | Bóng nhẹ |
| `ring-1 ring-gray-950/5 dark:ring-white/10` | Border style Filament |
| `text-gray-500 dark:text-gray-400` | Text muted |
| `text-gray-900 dark:text-white` | Text chính |

---

## 11. PHP Enums cho Status Fields

Filament 5 hỗ trợ native PHP Enums trong Select, Badge, Filter.

### 11.1 Tạo Enum

```php
<?php

namespace App\Enums;

enum CourtStatus: string
{
    case Active = 'active';
    case Maintenance = 'maintenance';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Hoạt động',
            self::Maintenance => 'Bảo trì',
            self::Inactive => 'Ngưng',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Maintenance => 'warning',
            self::Inactive => 'danger',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Active => 'heroicon-o-check-circle',
            self::Maintenance => 'heroicon-o-wrench',
            self::Inactive => 'heroicon-o-x-circle',
        };
    }
}
```

### 11.2 Dùng Enum trong Resource

```php
// Form: Select với Enum
Select::make('status')
    ->label('Trạng thái')
    ->options(CourtStatus::class)  // Filament tự gọi ->label()
    ->default(CourtStatus::Active)
    ->required();

// Table: Badge với Enum
TextColumn::make('status')
    ->label('Trạng thái')
    ->badge()
    ->color(fn (CourtStatus $state): string => $state->color());

// Filter: SelectFilter với Enum
SelectFilter::make('status')
    ->label('Trạng thái')
    ->options(CourtStatus::class);
```

### 11.3 Model Cast

```php
// Trong Model
protected $casts = [
    'status' => CourtStatus::class,
];
```

> [!TIP]
> Khi Model có cast Enum, Filament tự detect và truyền Enum instance vào `$state`.
> Dùng `fn (CourtStatus $state)` thay vì `fn (string $state)` trong closures.

---

## 12. Custom Pages (Non-Resource)

Custom pages (Settings, Reports) dùng `Filament\Pages\Page`, **KHÔNG PHẢI** `Filament\Resources\Pages\Page`.

```php
<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSettings extends Page
{
    protected static string $routePath = '/settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Cài đặt';

    protected static ?string $title = 'Cài đặt hệ thống';

    protected static string|UnitEnum|null $navigationGroup = 'Hệ thống';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        // Load data
        $this->form->fill([]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Tiêu đề')
                ->schema([
                    TextInput::make('name')->label('Tên'),
                ])
                ->columns(2),
        ])->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Lưu')
                ->action('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        // Save logic
        Notification::make()->title('Đã lưu')->success()->send();
    }
}
```

> [!CAUTION]
> **Custom Page type declarations — PHẢI DÙNG ĐÚNG:**
> - `$navigationIcon` → `protected static string|BackedEnum|null` (dùng `Heroicon::OutlinedXxx`)
> - `$navigationGroup` → `protected static string|UnitEnum|null` (KHÔNG PHẢI `?string`)
> - `$view` → `protected string` (KHÔNG có `static`)
> - `$heading` (Widget) → `protected ?string` (KHÔNG có `static`)

### 12.1 Blade View cho Custom Page

```blade
{{-- resources/views/filament/pages/manage-settings.blade.php --}}
<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="fi-form-actions">
            <x-filament::button type="submit">
                Lưu cài đặt
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
```

> [!WARNING]
> **KHÔNG dùng** `<x-filament-panels::form.actions>` — component này KHÔNG tồn tại trong Filament 5.
> Thay vào đó dùng `<x-filament::button>` bọc trong `<div class="fi-form-actions">`.

---

## 13. Form Field Patterns

### 13.1 Reactive Fields (afterStateUpdated)

Khi field A thay đổi → tự động cập nhật field B:

```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Set;
use Filament\Forms\Get;

TextInput::make('warranty_months')
    ->label('Số tháng BH')
    ->numeric()
    ->default(12)
    ->live()                          // BẮT BUỘC để reactive hoạt động
    ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
        if ($state && $get('start_date')) {
            $expiry = \Carbon\Carbon::parse($get('start_date'))
                ->addMonths((int) $state);
            $set('expiration_date', $expiry->format('Y-m-d'));
        }
    }),
```

> [!IMPORTANT]
> **`->live()`** (hoặc `->reactive()`) BẮT BUỘC phải có trước `->afterStateUpdated()`.
> Nếu thiếu `->live()`, callback sẽ KHÔNG ĐƯỢC GỌI.

### 13.2 Conditional Visibility

Hiện/ẩn field dựa trên giá trị field khác:

```php
Select::make('payment_method')
    ->label('Phương thức')
    ->options([
        'cash' => 'Tiền mặt',
        'transfer' => 'Chuyển khoản',
        'card' => 'Thẻ tín dụng',
    ])
    ->live(),                         // ← cũng cần live()

TextInput::make('transfer_target')
    ->label('Số tài khoản')
    ->visible(fn (Get $get) => $get('payment_method') === 'transfer'),

// Hoặc dùng ->hidden() ngược lại
TextInput::make('receipt_number')
    ->hidden(fn (Get $get) => $get('payment_method') !== 'cash'),
```

### 13.3 Validation Rules

```php
TextInput::make('email')
    ->email()
    ->required()
    ->unique(ignoreRecord: true)                    // unique trừ record hiện tại
    ->maxLength(255),

TextInput::make('amount')
    ->numeric()
    ->minValue(0)
    ->maxValue(999999999)
    ->step(1000)
    ->prefix('₫')
    ->inputMode('numeric'),

TextInput::make('phone')
    ->tel()
    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),

Select::make('status')
    ->required()
    ->in(['active', 'inactive'])      // server-side validation
    ->native(false),                  // dropdown đẹp hơn native select
```

### 13.4 Placeholder & Disabled States

```php
// Read-only computed value
Placeholder::make('total_formatted')
    ->label('Tổng cộng')
    ->content(fn ($record) => number_format($record?->total ?? 0) . 'đ'),

// Disabled nhưng vẫn submit value
TextInput::make('code')
    ->disabled()
    ->dehydrated(),                   // GIỮ giá trị khi submit dù disabled

// Disabled và KHÔNG submit value
TextInput::make('computed_field')
    ->disabled()
    ->dehydrated(false),              // BỎ khỏi submitted data
```

### 13.5 Default Values & Mutators

```php
// Default khi create
TextInput::make('code')
    ->default(fn () => 'WO-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT)),

// Modify value trước khi save
TextInput::make('amount')
    ->dehydrateStateUsing(fn ($state) => (int) str_replace(['.', ','], '', $state)),

// Modify value sau khi load từ DB
TextInput::make('amount')
    ->formatStateUsing(fn ($state) => number_format($state ?? 0)),
```

---

## 14. Table Column Patterns

### 14.1 Format & Display

```php
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;

// Format tiền VNĐ
TextColumn::make('amount')
    ->label('Số tiền')
    ->formatStateUsing(fn ($state) => number_format($state) . 'đ')
    ->sortable()
    ->alignEnd(),

// Hoặc dùng money()
TextColumn::make('total')
    ->money('VND'),

// Format ngày tiếng Việt
TextColumn::make('created_at')
    ->dateTime('d/m/Y H:i')
    ->sortable()
    ->since(),                        // "2 giờ trước" — tooltip full date

// Limit text dài
TextColumn::make('description')
    ->limit(50)
    ->tooltip(fn ($record) => $record->description),   // hover xem full

// Wrap text
TextColumn::make('notes')
    ->wrap()
    ->lineClamp(3),                   // max 3 dòng
```

### 14.2 Badge Columns

```php
// Badge với Enum (khuyên dùng — xem Section 11)
TextColumn::make('status')
    ->badge()
    ->color(fn (WorkOrderStatus $state) => $state->color()),

// Badge với string values
TextColumn::make('priority')
    ->badge()
    ->formatStateUsing(fn (string $state) => match($state) {
        'urgent' => 'Khẩn cấp',
        'high' => 'Cao',
        'normal' => 'Bình thường',
        'low' => 'Thấp',
        default => $state,
    })
    ->color(fn (string $state) => match($state) {
        'urgent' => 'danger',
        'high' => 'warning',
        'normal' => 'primary',
        'low' => 'gray',
        default => 'gray',
    })
    ->icon(fn (string $state) => match($state) {
        'urgent' => 'heroicon-o-fire',
        'high' => 'heroicon-o-arrow-up',
        default => null,
    }),
```

### 14.3 Toggleable & Hidden Columns

```php
// Hiện mặc định, cho phép ẩn
TextColumn::make('email')
    ->toggleable(),

// Ẩn mặc định, cho phép hiện
TextColumn::make('created_at')
    ->toggleable(isToggledHiddenByDefault: true),
```

### 14.4 Aggregate & Relationship Columns

```php
// Count relationship
TextColumn::make('tasks_count')
    ->counts('tasks')
    ->label('Số việc')
    ->sortable(),

// Nested relationship
TextColumn::make('customer.name')
    ->label('Khách hàng')
    ->searchable(),

// Summarize (footer)
TextColumn::make('amount')
    ->summarize([
        Sum::make()->label('Tổng'),
        Average::make()->label('TB'),
    ]),
```

### 14.5 Copyable & URL Columns

```php
TextColumn::make('serial_number')
    ->copyable()                      // click to copy
    ->copyMessage('Đã copy!')
    ->copyMessageDuration(1500),

TextColumn::make('website')
    ->url(fn ($record) => $record->website, shouldOpenInNewTab: true),
```

---

## 15. Widget Patterns

### 15.1 StatsOverviewWidget

```php
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MyStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;                // thứ tự trên dashboard

    protected function getStats(): array
    {
        return [
            Stat::make('Tổng đơn', Order::count())
                ->description('Tăng 12%')
                ->descriptionIcon('heroicon-o-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5])     // sparkline mini chart
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirect('/admin/orders')",
                ]),
        ];
    }
}
```

### 15.2 ChartWidget

```php
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Doanh thu';       // ⚠️ KHÔNG có static
    protected ?string $maxHeight = '300px';          // ⚠️ KHÔNG có static

    protected static ?int $sort = 3;                // ✅ CÓ static

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Doanh thu',
                    'data' => [100, 200, 150, 300, 250, 400],
                    'borderColor' => 'rgb(245, 158, 11)',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'],
        ];
    }

    protected function getType(): string
    {
        return 'line';      // 'line', 'bar', 'pie', 'doughnut', 'radar', 'polarArea'
    }

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Tuần này',
            'month' => 'Tháng này',
            'year' => 'Năm nay',
        ];
    }
}
```

### 15.3 TableWidget

```php
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LatestOrdersWidget extends TableWidget
{
    protected static ?string $heading = 'Đơn gần đây';  // ⚠️ CÓ static (khác ChartWidget!)
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';     // full width

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('code')->badge(),
                TextColumn::make('total')->money('VND'),
            ])
            ->paginated(false);
    }
}
```

> [!CAUTION]
> **Static vs Non-static properties trong Widgets:**
>
> | Property | ChartWidget | TableWidget | StatsOverviewWidget |
> |----------|-------------|-------------|---------------------|
> | `$heading` | `protected ?string` | `protected static ?string` | N/A |
> | `$sort` | `protected static ?int` | `protected static ?int` | `protected static ?int` |
> | `$maxHeight` | `protected ?string` | N/A | N/A |
> | `$columnSpan` | `protected int\|string\|array` | `protected int\|string\|array` | N/A |

---

## 16. AdminPanelProvider Configuration

### 16.1 Navigation Groups (Ordering & Icons)

```php
use Filament\Navigation\NavigationGroup;

->navigationGroups([
    NavigationGroup::make('CRM'),
    NavigationGroup::make('Nghiệp vụ'),
    NavigationGroup::make('Bảo hành'),
    NavigationGroup::make('Hệ thống'),
])
```

> [!WARNING]
> Nếu navigation group có `->icon()`, thì **tất cả items** bên trong group **KHÔNG ĐƯỢC** có icon riêng.
> Filament 5 ném exception: *"Navigation group has an icon but one or more of its items also have icons."*
> → Chọn 1: hoặc group có icon, hoặc items có icon. **Không được cả hai.**

### 16.2 Discover Resources & Widgets

```php
// Auto-discover tất cả resources/pages/widgets trong thư mục
->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
```

### 16.3 Bỏ Default Widgets

```php
// Bỏ AccountWidget (Đăng xuất) và FilamentInfoWidget
->widgets([])       // mảng rỗng = không widget mặc định
```

### 16.4 Database Notifications

```php
->databaseNotifications()           // bật notification bell trên header
->databaseNotificationsPolling('30s')  // poll mỗi 30s (optional)
```

### 16.5 Full Example

```php
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\Support\Colors\Color;

public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->login()
        ->colors(['primary' => Color::Amber])
        ->databaseNotifications()
        ->navigationGroups([
            NavigationGroup::make('CRM'),
            NavigationGroup::make('Nghiệp vụ'),
            NavigationGroup::make('Hệ thống'),
        ])
        ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
        ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
        ->widgets([])
        ->plugins([
            FilamentShieldPlugin::make()
                ->navigationGroup('Hệ thống')
                ->navigationSort(12),
        ]);
}
```

---

## 17. Relationship Handling in Forms

### 17.1 Select + BelongsTo

```php
Select::make('customer_id')
    ->label('Khách hàng')
    ->relationship('customer', 'name')    // auto-load từ relationship
    ->searchable()                         // search trong dropdown
    ->preload()                            // preload tất cả options
    ->createOptionForm([                   // tạo mới ngay trong dropdown
        TextInput::make('name')->required(),
        TextInput::make('phone'),
    ])
    ->editOptionForm([                     // sửa ngay trong dropdown
        TextInput::make('name')->required(),
    ]),
```

### 17.2 Select + BelongsToMany (Multiple)

```php
Select::make('assignees')
    ->label('Nhân viên phụ trách')
    ->relationship('assignees', 'name')
    ->multiple()                           // chọn nhiều
    ->searchable()
    ->preload()
    ->pivotData([                          // thêm data vào pivot table
        'assigned_by' => auth()->id(),
    ]),
```

### 17.3 CheckboxList + BelongsToMany

```php
CheckboxList::make('tags')
    ->label('Nhãn')
    ->relationship('tags', 'name')
    ->columns(3)                           // 3 cột checkbox
    ->searchable()
    ->bulkToggleable(),                    // nút chọn/bỏ chọn tất cả
```

### 17.4 Repeater + HasMany

```php
use Filament\Forms\Components\Repeater;

Repeater::make('items')
    ->relationship('items')                // auto CRUD qua relationship
    ->schema([
        TextInput::make('name')->required(),
        TextInput::make('quantity')->numeric()->default(1),
        TextInput::make('unit_price')->numeric()->prefix('₫'),
    ])
    ->columns(3)
    ->defaultItems(1)                      // bắt đầu với 1 row
    ->addActionLabel('Thêm mục')
    ->reorderable()                        // kéo thả sắp xếp
    ->cloneable()                          // nút clone row
    ->collapsible()
    ->itemLabel(fn (array $state): ?string =>
        $state['name'] ?? 'Mục mới'        // label hiển thị khi collapsed
    ),
```

> [!IMPORTANT]
> Khi dùng `Repeater::make('items')->relationship('items')`, Filament tự động:
> - **Create**: tạo record con khi tạo record cha
> - **Update**: cập nhật record con khi sửa record cha
> - **Delete**: xóa record con khi xóa row trong repeater
>
> **KHÔNG CẦN** xử lý thủ công trong `afterCreate()` / `afterSave()`.

### 17.5 MorphToSelect (Polymorphic)

```php
use Filament\Forms\Components\MorphToSelect;

MorphToSelect::make('commentable')
    ->label('Gắn vào')
    ->types([
        MorphToSelect\Type::make(WorkOrder::class)
            ->titleAttribute('code'),
        MorphToSelect\Type::make(Task::class)
            ->titleAttribute('title'),
    ])
    ->searchable()
    ->preload(),
```

---

## 18. Set/Get Utilities & Tabs\Tab — Lưu ý quan trọng

### 18.1 Set và Get (afterStateUpdated)

Trong Filament 5, `Set` và `Get` đã chuyển sang namespace mới:

| ❌ SAI (v3/v4) | ✅ ĐÚNG (v5) |
|---|---|
| `use Filament\Forms\Set` | `use Filament\Schemas\Components\Utilities\Set` |
| `use Filament\Forms\Get` | `use Filament\Schemas\Components\Utilities\Get` |

> [!CAUTION]
> **Cách an toàn nhất: KHÔNG type-hint Set/Get**. Để Filament tự inject qua tên biến.

```php
// ❌ SAI — crash vì sai namespace
use Filament\Forms\Set;
->afterStateUpdated(function (string $state, Set $set) { ... })

// ✅ ĐÚNG — không type-hint, Filament tự nhận qua tên biến $set, $get
->afterStateUpdated(function (string $state, $set) {
    $set('customer_id', $customer->id);
    $set('contact_person', $customer->name);
})

// ✅ ĐÚNG — nếu muốn type-hint thì dùng namespace mới
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
->afterStateUpdated(function (string $state, Set $set, Get $get) { ... })
```

### 18.2 Tabs\Tab — Luôn import riêng

```php
// ❌ SAI — dùng inline Tabs\Tab::make()
use Filament\Schemas\Components\Tabs;

Tabs::make('label')->tabs([
    Tabs\Tab::make('Tab 1')->schema([...]),  // ← dễ lỗi namespace
]);

// ✅ ĐÚNG — import Tab riêng
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

Tabs::make('label')->tabs([
    Tab::make('Tab 1')->schema([...]),       // ← sạch, rõ ràng
    Tab::make('Tab 2')->schema([...]),
]);
```

> [!IMPORTANT]
> Tương tự cho `Wizard\Step`:
> ```php
> use Filament\Schemas\Components\Wizard;
> use Filament\Schemas\Components\Wizard\Step;
> ```


---

## 10. Theming — Tuỳ biến giao diện Filament

### 10.1 Tạo Custom Theme

```bash
php artisan make:filament-theme
php artisan make:filament-theme admin  # nếu nhiều panel
```

Tạo ra:
- `resources/css/filament/admin/theme.css` — file CSS override
- `resources/css/filament/admin/tailwind.config.js` — Tailwind config riêng

### 10.2 Đăng ký theme trong Panel Provider

```php
->viteTheme('resources/css/filament/admin/theme.css')
```

Thêm vào `vite.config.js` input array:
```js
'resources/css/filament/admin/theme.css',
```

### 10.3 Tuỳ biến màu sắc (Colors)

```php
use Filament\Support\Colors\Color;

// Preset có sẵn:
->colors([
    'primary' => Color::Amber,
    'danger'  => Color::Rose,
    'success' => Color::Emerald,
    'info'    => Color::Sky,
    'gray'    => Color::Slate,
])

// Từ hex — Filament tự tạo palette:
->colors(['primary' => Color::hex('#2563eb')])

// Array RGB 11 shades (50→950):
->colors(['primary' => [50 => '239, 246, 255', ..., 950 => '23, 37, 84']])
```

> [!NOTE]
> 6 màu chuẩn: `primary`, `danger`, `warning`, `success`, `info`, `gray`.
> Filament export CSS vars: `--primary-500`, `--danger-600`... cho mỗi shade.

### 10.4 Tuỳ biến Font

```php
->font('Nunito')                   // Google Fonts (tự load)

use Filament\FontProviders\GoogleFontProvider;
->font('Nunito', provider: GoogleFontProvider::class)

use Filament\FontProviders\LocalFontProvider;
->font('Inter', url: asset('fonts/inter.css'), provider: LocalFontProvider::class)
```

> [!NOTE]
> Font mặc định: **Inter**. Chỉ cần `->font('Tên font')` là đổi toàn panel.

### 10.5 Override Styles bằng `fi-` Classes

Filament dùng semantic CSS class prefix `fi-`:

| Class | Vùng |
|-------|------|
| `.fi-main` | Khu vực content chính |
| `.fi-sidebar` | Thanh sidebar |
| `.fi-topbar` | Thanh top navigation |
| `.fi-btn` | Tất cả buttons |
| `.fi-input` | Input fields |
| `.fi-badge` | Badge components |
| `.fi-modal` | Modal dialogs |
| `.fi-table` | Data tables |
| `.fi-header` | Page headers |

Cách dùng trong `theme.css`:
```css
.fi-btn { @apply rounded-sm; }
.fi-sidebar { @apply bg-gray-900; }
.fi-table { @apply text-xs; }
```

> [!TIP]
> Dùng DevTools browser (F12 → Inspect) để tìm đúng `fi-*` class cần override.

### 10.6 Dark Mode

```php
->darkMode(false)   // Tắt dark mode
```

Override CSS vars trong `theme.css`:
```css
:root { --primary-500: 59, 130, 246; }
.dark { --primary-500: 96, 165, 250; }
```

Tailwind config cần có:
```js
darkMode: 'class',  // Filament dùng class-based dark mode
```

### 10.7 Panel Provider — Tuỳ biến nhanh không cần CSS

```php
->brandName('CNET Tech')
->brandLogo(asset('images/logo.svg'))
->brandLogoHeight('2rem')
->favicon(asset('favicon.ico'))
->maxContentWidth('full')               // 'xl', '2xl', '7xl', 'full'
->sidebarCollapsibleOnDesktop()
->sidebarFullyCollapsibleOnDesktop()
->topNavigation()                       // sidebar → top navigation bar
->spa()                                 // SPA mode (Livewire navigate)
->darkMode(false)
```

### 10.8 Workflow tổng thể custom theme

```
1. php artisan make:filament-theme admin
2. Thêm CSS path vào vite.config.js input
3. ->viteTheme(...) trong AdminPanelProvider
4. npm run dev
5. Màu: ->colors([...])
6. Font: ->font('...')
7. Override fi- classes trong theme.css
8. Dark: .dark { --var: value; }
```

---

## 18. SlugInput Pattern (Project Convention)

### 18.1 Component Location

```
app/Filament/Components/SlugInput.php
```

### 18.2 Cách dùng

```php
use App\Filament\Components\SlugInput;

// Trong Form schema — dùng spread operator
...SlugInput::make(nameField: 'name', label: 'Ten dich vu'),
...SlugInput::make(nameField: 'title', label: 'Tieu de bai viet'),
```

### 18.3 Tinh nang

- Auto-generate: Blur ra khoi name/title -> slug tu dong tao (tieng Viet khong dau + .html)
- URL prefix: Slug field hien thi domain lam prefix (admin thay full URL)
- Edit tu do: Admin tu sua slug, sanitizeSlug() clean input khi blur
- Edit mode guard: Khi edit record da co, slug giu nguyen
- Unique validation: Server-side unique(ignoreRecord: true)

### 18.4 Collision handling

SlugObserver tu dong append -1, -2, -3... neu slug trung voi model type khac.

---

## 19. Layout & Column Patterns — QUY TẮC BẮT BUỘC

> [!CAUTION]
> **Đây là phần quan trọng nhất khi tạo Form/Infolist.** Đọc kỹ trước khi viết bất kỳ Schema nào.

### 19.1 Nguyên tắc cốt lõi

```
Section → columns(N)  →  grid N cột
Field   → columnSpan(X)  →  field này chiếm X cột trong grid đó
Field   → columnSpanFull()  →  field chiếm TOÀN BỘ chiều ngang
```

**Quy tắc ưu tiên:**
- **Field đầu tiên luôn full-width** (title, tên, tiêu đề) — dùng `->columnSpanFull()`
- **RichEditor, Textarea, FileUpload** → LUÔN `->columnSpanFull()`
- **Toggle/Checkbox cuối** → `->columnSpanFull()` để không bị kẹt cột lẻ
- **TextInput ngắn** (URL, số, code) → để tự fill columns

### 19.2 Pattern chuẩn — Form 2 Section

Pattern này được dùng cho **MỌI** Resource trong dự án:

```php
return $schema->components([

    // ── Section 1: Nội dung — full width ──────────────────────────
    Section::make('Nội dung')
        ->icon('heroicon-o-document-text')
        ->schema([
            TextInput::make('title')
                ->label('Tiêu đề')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),   // ← LUÔN full cho title

            TextInput::make('subtitle')
                ->label('Phụ đề')
                ->maxLength(255),     // ← 1 cột trong grid 2

            Select::make('category_id')
                ->label('Danh mục')
                ->relationship('category', 'name'),  // ← 1 cột trong grid 2

            FileUpload::make('thumbnail')
                ->label('Ảnh đại diện')
                ->image()
                ->columnSpanFull(),   // ← LUÔN full cho FileUpload

            RichEditor::make('content')
                ->label('Nội dung')
                ->columnSpanFull(),   // ← LUÔN full cho RichEditor
        ])
        ->columns(2),                 // grid 2 cột cho toàn section

    // ── Section 2: Meta & Cài đặt — nhiều cột nhỏ ────────────────
    Section::make('Cài đặt')
        ->icon('heroicon-o-cog-6-tooth')
        ->description('SEO và thứ tự hiển thị')
        ->schema([
            TextInput::make('meta_title')->label('Meta title'),
            TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
            Select::make('status')->label('Trạng thái')->options([...]),
            Toggle::make('is_active')->label('Hiển thị')->columnSpanFull(),
        ])
        ->columns(3)
        ->collapsed(false),
]);
```

### 19.3 Quick Reference — số columns theo loại form

| Loại form | Section 1 | Section 2 (meta) |
|---|---|---|
| Bài viết, dịch vụ | `->columns(2)` | `->columns(3)` |
| Sản phẩm | `->columns(2)` | `->columns(4)` |
| Trang đơn giản (slider, intro) | `->columns(2)` | `->columns(3)` |
| Cài đặt hệ thống | `->columns(1)` hoặc Section riêng từng loại |

### 19.4 columnSpan chính xác

```php
// Trong grid 3 cột, field chiếm 2 cột:
TextInput::make('title')->columnSpan(2),

// Trong grid 3 cột, field chiếm 1 cột (mặc định):
TextInput::make('code'),            // không cần ghi gì thêm

// Chiếm toàn bộ chiều ngang (bất kể grid bao nhiêu cột):
RichEditor::make('content')->columnSpanFull(),

// Responsive: desktop 2 cột, mobile full:
TextInput::make('name')->columnSpan(['default' => 'full', 'md' => 1]),
```

### 19.5 Grid component độc lập (trong Section)

Khi cần chia layout phức tạp hơn bên trong một Section:

```php
use Filament\Schemas\Components\Grid;

Section::make('Thông tin')
    ->schema([
        Grid::make(3)->schema([          // ← grid 3 cột bên trong section
            TextInput::make('a'),
            TextInput::make('b'),
            TextInput::make('c'),
        ]),
        RichEditor::make('content')->columnSpanFull(),
    ])
    ->columns(1),     // section columns(1) để Grid tự quản lý
```

### 19.6 Sidebar layout (2 cột không đều)

```php
return $schema
    ->columns([
        'lg' => 3,   // desktop: 3 cột
    ])
    ->components([
        // Main content: chiếm 2/3
        Section::make('Nội dung')
            ->schema([...])
            ->columnSpan(['lg' => 2]),

        // Sidebar: chiếm 1/3
        Section::make('Cài đặt')
            ->schema([...])
            ->columnSpan(['lg' => 1]),
    ]);
```

> [!TIP]
> **Sidebar layout** lý tưởng cho post/service edit form: nội dung bên trái, meta SEO + publish bên phải.

### 19.7 Checklist trước khi commit Form

- [ ] Field đầu tiên (title/name) có `->columnSpanFull()`?
- [ ] Tất cả `FileUpload`, `RichEditor`, `Textarea` có `->columnSpanFull()`?
- [ ] Toggle/Checkbox cuối cùng trong section có `->columnSpanFull()`?
- [ ] Section `->columns(N)` đã set chưa? (mặc định là 1 cột nếu không set)
- [ ] Section có `->icon()`? (bắt buộc theo convention dự án)
- [ ] `RichEditor` **KHÔNG** khai `->toolbarButtons()` → dùng full toolbar mặc định
- [ ] `sort_order` field trong form? → **KHÔNG** nếu Table đã có drag-sort/reorder column
