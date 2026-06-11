<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide;

use Filament\Actions\View\ActionsIconAlias;
use Filament\Forms\View\FormsIconAlias;
use Filament\Infolists\View\InfolistsIconAlias;
use Filament\Notifications\View\NotificationsIconAlias;
use Filament\QueryBuilder\View\QueryBuilderIconAlias;
use Filament\Schemas\View\SchemaIconAlias;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\View\SupportIconAlias;
use Filament\Tables\View\TablesIconAlias;
use Filament\View\PanelsIconAlias;
use Filament\Widgets\View\WidgetsIconAlias;
use Illuminate\Support\ServiceProvider;

/**
 * The Filament overlay: applies the alias overrides that re-skin Filament's
 * built-in chrome icons to Lucide. Auto-discovered but self-guarding, so it
 * no-ops when Filament is absent and never burdens a non-Filament app
 * (ADR-0002).
 */
final class LucideFilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // `::class` never autoloads, so this is safe with Filament absent.
        // The guard also keeps aliasOverrides()'s Filament constant
        // references from autoloading until we know Filament is present.
        if (! class_exists(FilamentIcon::class)) {
            return;
        }

        FilamentIcon::register(self::aliasOverrides());
    }

    /**
     * Filament icon slots deliberately left to their built-in default rather
     * than re-skinned to Lucide. These are explicit exceptions to the package's
     * "every chrome icon becomes Lucide" goal, kept here so the choice is
     * visible and the completeness guard stays meaningful.
     *
     * The GitHub button is a hardcoded GitHub brand-logo SVG; neither Lucide
     * nor Heroicons ships a GitHub glyph, so there is no faithful replacement
     * and Filament's own logo is the best icon for the slot.
     *
     * @return array<int, string>
     */
    public static function unmappedAliases(): array
    {
        return [
            PanelsIconAlias::WIDGETS_FILAMENT_INFO_OPEN_GITHUB_BUTTON,
        ];
    }

    /**
     * The hand-authored alias-override map: every Filament chrome icon slot
     * mapped to the Lucide glyph that replaces its Heroicon default. The only
     * Filament-coupled, non-generated part of the package (CONTEXT.md). Each
     * Lucide glyph is chosen as the faithful Lucide equivalent of the slot's
     * Heroicon default; the FilamentOverlayTest guards that no slot is left
     * unmapped as Filament evolves.
     *
     * @return array<string, Lucide>
     */
    public static function aliasOverrides(): array
    {
        return [
            // Actions
            ActionsIconAlias::ACTION_GROUP => Lucide::EllipsisVertical,
            ActionsIconAlias::CREATE_ACTION_GROUPED => Lucide::Plus,
            ActionsIconAlias::DELETE_ACTION => Lucide::TrashTwo,
            ActionsIconAlias::DELETE_ACTION_GROUPED => Lucide::TrashTwo,
            ActionsIconAlias::DELETE_ACTION_MODAL => Lucide::TrashTwo,
            ActionsIconAlias::DETACH_ACTION => Lucide::X,
            ActionsIconAlias::DETACH_ACTION_MODAL => Lucide::X,
            ActionsIconAlias::DISSOCIATE_ACTION => Lucide::X,
            ActionsIconAlias::DISSOCIATE_ACTION_MODAL => Lucide::X,
            ActionsIconAlias::EDIT_ACTION => Lucide::SquarePen,
            ActionsIconAlias::EDIT_ACTION_GROUPED => Lucide::SquarePen,
            ActionsIconAlias::EXPORT_ACTION_GROUPED => Lucide::Download,
            ActionsIconAlias::FORCE_DELETE_ACTION => Lucide::TrashTwo,
            ActionsIconAlias::FORCE_DELETE_ACTION_GROUPED => Lucide::TrashTwo,
            ActionsIconAlias::FORCE_DELETE_ACTION_MODAL => Lucide::TrashTwo,
            ActionsIconAlias::IMPORT_ACTION_GROUPED => Lucide::Upload,
            ActionsIconAlias::MODAL_CONFIRMATION => Lucide::TriangleAlert,
            ActionsIconAlias::REPLICATE_ACTION => Lucide::Copy,
            ActionsIconAlias::REPLICATE_ACTION_GROUPED => Lucide::Copy,
            ActionsIconAlias::RESTORE_ACTION => Lucide::UndoTwo,
            ActionsIconAlias::RESTORE_ACTION_GROUPED => Lucide::UndoTwo,
            ActionsIconAlias::RESTORE_ACTION_MODAL => Lucide::UndoTwo,
            ActionsIconAlias::VIEW_ACTION => Lucide::Eye,
            ActionsIconAlias::VIEW_ACTION_GROUPED => Lucide::Eye,

            // Panels
            PanelsIconAlias::GLOBAL_SEARCH_FIELD => Lucide::Search,
            PanelsIconAlias::PAGES_DASHBOARD_ACTIONS_FILTER => Lucide::ListFilter,
            PanelsIconAlias::PAGES_DASHBOARD_NAVIGATION_ITEM => Lucide::LayoutDashboard,
            PanelsIconAlias::PAGES_PASSWORD_RESET_REQUEST_PASSWORD_RESET_ACTIONS_LOGIN => Lucide::ArrowLeft,
            PanelsIconAlias::PAGES_PASSWORD_RESET_REQUEST_PASSWORD_RESET_ACTIONS_LOGIN_RTL => Lucide::ArrowRight,
            PanelsIconAlias::RESOURCES_PAGES_EDIT_RECORD_NAVIGATION_ITEM => Lucide::Pencil,
            PanelsIconAlias::RESOURCES_PAGES_MANAGE_RELATED_RECORDS_NAVIGATION_ITEM => Lucide::Files,
            PanelsIconAlias::RESOURCES_PAGES_VIEW_RECORD_NAVIGATION_ITEM => Lucide::Eye,
            PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON => Lucide::PanelLeftClose,
            PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON_RTL => Lucide::PanelRightClose,
            PanelsIconAlias::SIDEBAR_EXPAND_BUTTON => Lucide::PanelLeftOpen,
            PanelsIconAlias::SIDEBAR_EXPAND_BUTTON_RTL => Lucide::PanelRightOpen,
            PanelsIconAlias::SIDEBAR_GROUP_COLLAPSE_BUTTON => Lucide::ChevronDown,
            PanelsIconAlias::SUB_NAVIGATION_MOBILE_MENU_BUTTON => Lucide::Menu,
            PanelsIconAlias::TENANT_MENU_BILLING_BUTTON => Lucide::CreditCard,
            PanelsIconAlias::TENANT_MENU_PROFILE_BUTTON => Lucide::Settings,
            PanelsIconAlias::TENANT_MENU_REGISTRATION_BUTTON => Lucide::Plus,
            PanelsIconAlias::TENANT_MENU_TOGGLE_BUTTON => Lucide::ChevronsUpDown,
            PanelsIconAlias::THEME_SWITCHER_LIGHT_BUTTON => Lucide::Sun,
            PanelsIconAlias::THEME_SWITCHER_DARK_BUTTON => Lucide::Moon,
            PanelsIconAlias::THEME_SWITCHER_SYSTEM_BUTTON => Lucide::MonitorCog,
            PanelsIconAlias::TOPBAR_CLOSE_SIDEBAR_BUTTON => Lucide::X,
            PanelsIconAlias::TOPBAR_OPEN_SIDEBAR_BUTTON => Lucide::Menu,
            PanelsIconAlias::TOPBAR_GROUP_TOGGLE_BUTTON => Lucide::ChevronsUpDown,
            PanelsIconAlias::TOPBAR_OPEN_DATABASE_NOTIFICATIONS_BUTTON => Lucide::Bell,
            PanelsIconAlias::SIDEBAR_OPEN_DATABASE_NOTIFICATIONS_BUTTON => Lucide::Bell,
            PanelsIconAlias::USER_MENU_PROFILE_ITEM => Lucide::Settings,
            PanelsIconAlias::USER_MENU_LOGOUT_BUTTON => Lucide::LogOut,
            PanelsIconAlias::USER_MENU_TOGGLE_BUTTON => Lucide::ChevronsUpDown,
            PanelsIconAlias::WIDGETS_ACCOUNT_LOGOUT_BUTTON => Lucide::LogOut,
            PanelsIconAlias::WIDGETS_FILAMENT_INFO_OPEN_DOCUMENTATION_BUTTON => Lucide::BookOpen,
            // GitHub button intentionally omitted — see unmappedAliases().

            // Forms
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_CLONE => Lucide::Copy,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_COLLAPSE => Lucide::ChevronUp,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_DELETE => Lucide::TrashTwo,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_EXPAND => Lucide::ChevronDown,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_MOVE_DOWN => Lucide::ArrowDown,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_MOVE_UP => Lucide::ArrowUp,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_REORDER => Lucide::ArrowUpDown,
            FormsIconAlias::COMPONENTS_CHECKBOX_LIST_SEARCH_FIELD => Lucide::Search,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_DRAG_CROP => Lucide::Crop,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_DRAG_MOVE => Lucide::Move,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_FLIP_HORIZONTAL => Lucide::FlipHorizontal,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_FLIP_VERTICAL => Lucide::FlipVertical,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_MOVE_DOWN => Lucide::ArrowDown,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_MOVE_LEFT => Lucide::ArrowLeft,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_MOVE_RIGHT => Lucide::ArrowRight,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_MOVE_UP => Lucide::ArrowUp,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ROTATE_LEFT => Lucide::RotateCcw,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ROTATE_RIGHT => Lucide::RotateCw,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ZOOM_100 => Lucide::Maximize,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ZOOM_IN => Lucide::ZoomIn,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ZOOM_OUT => Lucide::ZoomOut,
            FormsIconAlias::COMPONENTS_KEY_VALUE_ACTIONS_DELETE => Lucide::TrashTwo,
            FormsIconAlias::COMPONENTS_KEY_VALUE_ACTIONS_REORDER => Lucide::ArrowUpDown,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_CLONE => Lucide::Copy,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_COLLAPSE => Lucide::ChevronUp,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_DELETE => Lucide::TrashTwo,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_EXPAND => Lucide::ChevronDown,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_MOVE_DOWN => Lucide::ArrowDown,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_MOVE_UP => Lucide::ArrowUp,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_REORDER => Lucide::ArrowUpDown,
            FormsIconAlias::COMPONENTS_RICH_EDITOR_PANELS_CUSTOM_BLOCKS_CLOSE_BUTTON => Lucide::X,
            FormsIconAlias::COMPONENTS_RICH_EDITOR_PANELS_CUSTOM_BLOCK_DELETE_BUTTON => Lucide::TrashTwo,
            FormsIconAlias::COMPONENTS_RICH_EDITOR_PANELS_CUSTOM_BLOCK_EDIT_BUTTON => Lucide::SquarePen,
            FormsIconAlias::COMPONENTS_RICH_EDITOR_PANELS_MERGE_TAGS_CLOSE_BUTTON => Lucide::X,
            FormsIconAlias::COMPONENTS_SELECT_ACTIONS_CREATE_OPTION => Lucide::Plus,
            FormsIconAlias::COMPONENTS_SELECT_ACTIONS_EDIT_OPTION => Lucide::SquarePen,
            FormsIconAlias::COMPONENTS_TEXT_INPUT_ACTIONS_COPY => Lucide::ClipboardCopy,
            FormsIconAlias::COMPONENTS_TEXT_INPUT_ACTIONS_HIDE_PASSWORD => Lucide::EyeOff,
            FormsIconAlias::COMPONENTS_TEXT_INPUT_ACTIONS_SHOW_PASSWORD => Lucide::Eye,
            FormsIconAlias::COMPONENTS_TOGGLE_BUTTONS_BOOLEAN_FALSE => Lucide::X,
            FormsIconAlias::COMPONENTS_TOGGLE_BUTTONS_BOOLEAN_TRUE => Lucide::Check,

            // Infolists
            InfolistsIconAlias::COMPONENTS_ICON_ENTRY_FALSE => Lucide::CircleX,
            InfolistsIconAlias::COMPONENTS_ICON_ENTRY_TRUE => Lucide::CircleCheck,

            // Notifications
            NotificationsIconAlias::DATABASE_MODAL_EMPTY_STATE => Lucide::BellOff,
            NotificationsIconAlias::NOTIFICATION_CLOSE_BUTTON => Lucide::X,
            NotificationsIconAlias::NOTIFICATION_DANGER => Lucide::CircleX,
            NotificationsIconAlias::NOTIFICATION_INFO => Lucide::Info,
            NotificationsIconAlias::NOTIFICATION_SUCCESS => Lucide::CircleCheck,
            NotificationsIconAlias::NOTIFICATION_WARNING => Lucide::CircleAlert,

            // Query builder
            QueryBuilderIconAlias::ADD_RULE_ACTION => Lucide::Plus,
            QueryBuilderIconAlias::CONSTRAINTS_BOOLEAN => Lucide::CircleCheck,
            QueryBuilderIconAlias::CONSTRAINTS_DATE => Lucide::Calendar,
            QueryBuilderIconAlias::CONSTRAINTS_NUMBER => Lucide::Hash,
            QueryBuilderIconAlias::CONSTRAINTS_RELATIONSHIP => Lucide::Link,
            QueryBuilderIconAlias::CONSTRAINTS_SELECT => Lucide::ChevronsUpDown,
            QueryBuilderIconAlias::CONSTRAINTS_TEXT => Lucide::Type,
            QueryBuilderIconAlias::OR_GROUP_BLOCK => Lucide::Slash,
            QueryBuilderIconAlias::OR_GROUP_ADD_GROUP_ACTION => Lucide::Plus,

            // Schema
            SchemaIconAlias::COMPONENTS_CALLOUT_DANGER => Lucide::CircleX,
            SchemaIconAlias::COMPONENTS_CALLOUT_INFO => Lucide::Info,
            SchemaIconAlias::COMPONENTS_CALLOUT_SUCCESS => Lucide::CircleCheck,
            SchemaIconAlias::COMPONENTS_CALLOUT_WARNING => Lucide::CircleAlert,
            SchemaIconAlias::COMPONENTS_TABS_DROPDOWN_TRIGGER_BUTTON => Lucide::ChevronDown,
            SchemaIconAlias::COMPONENTS_TABS_MORE_TABS_BUTTON => Lucide::Ellipsis,
            SchemaIconAlias::COMPONENTS_WIZARD_COMPLETED_STEP => Lucide::Check,

            // Support
            SupportIconAlias::BADGE_DELETE_BUTTON => Lucide::X,
            SupportIconAlias::BREADCRUMBS_SEPARATOR => Lucide::ChevronRight,
            SupportIconAlias::BREADCRUMBS_SEPARATOR_RTL => Lucide::ChevronLeft,
            SupportIconAlias::MODAL_CLOSE_BUTTON => Lucide::X,
            SupportIconAlias::PAGINATION_FIRST_BUTTON => Lucide::ChevronsLeft,
            SupportIconAlias::PAGINATION_FIRST_BUTTON_RTL => Lucide::ChevronsRight,
            SupportIconAlias::PAGINATION_LAST_BUTTON => Lucide::ChevronsRight,
            SupportIconAlias::PAGINATION_LAST_BUTTON_RTL => Lucide::ChevronsLeft,
            SupportIconAlias::PAGINATION_NEXT_BUTTON => Lucide::ChevronRight,
            SupportIconAlias::PAGINATION_NEXT_BUTTON_RTL => Lucide::ChevronLeft,
            SupportIconAlias::PAGINATION_PREVIOUS_BUTTON => Lucide::ChevronLeft,
            SupportIconAlias::PAGINATION_PREVIOUS_BUTTON_RTL => Lucide::ChevronRight,
            SupportIconAlias::SECTION_COLLAPSE_BUTTON => Lucide::ChevronUp,

            // Tables
            TablesIconAlias::ACTIONS_DISABLE_REORDERING => Lucide::Check,
            TablesIconAlias::ACTIONS_ENABLE_REORDERING => Lucide::ArrowUpDown,
            TablesIconAlias::ACTIONS_FILTER => Lucide::ListFilter,
            TablesIconAlias::ACTIONS_GROUP => Lucide::Layers,
            TablesIconAlias::ACTIONS_OPEN_BULK_ACTIONS => Lucide::EllipsisVertical,
            TablesIconAlias::ACTIONS_COLUMN_MANAGER => Lucide::ColumnsThree,
            TablesIconAlias::COLUMNS_COLLAPSE_BUTTON => Lucide::ChevronDown,
            TablesIconAlias::COLUMNS_ICON_COLUMN_FALSE => Lucide::CircleX,
            TablesIconAlias::COLUMNS_ICON_COLUMN_TRUE => Lucide::CircleCheck,
            TablesIconAlias::EMPTY_STATE => Lucide::Inbox,
            TablesIconAlias::FILTERS_REMOVE_ALL_BUTTON => Lucide::X,
            TablesIconAlias::GROUPING_COLLAPSE_BUTTON => Lucide::ChevronUp,
            TablesIconAlias::HEADER_CELL_SORT_ASC_BUTTON => Lucide::ChevronUp,
            TablesIconAlias::HEADER_CELL_SORT_BUTTON => Lucide::ChevronsUpDown,
            TablesIconAlias::HEADER_CELL_SORT_DESC_BUTTON => Lucide::ChevronDown,
            TablesIconAlias::REORDER_HANDLE => Lucide::GripVertical,
            TablesIconAlias::SEARCH_FIELD => Lucide::Search,

            // Widgets
            WidgetsIconAlias::CHART_WIDGET_FILTER => Lucide::ListFilter,
        ];
    }
}
