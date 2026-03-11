<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên DA')->searchable()->sortable()->limit(50),
                ImageColumn::make('image')->label('Ảnh'),
                TextColumn::make('category.name')->label('Danh mục')->sortable(),
                TextColumn::make('client_name')->label('Khách hàng')->searchable(),
                TextColumn::make('project_date')->label('Ngày TH')->date('d/m/Y')->sortable(),
                ToggleColumn::make('is_featured')->label('Nổi bật'),
                TextColumn::make('view_count')->label('Lượt xem')->numeric()->sortable(),
                ToggleColumn::make('is_active')->label('Hiển thị'),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime('d/m/Y')
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category_id')->label('Danh mục')->relationship('category', 'name'),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
