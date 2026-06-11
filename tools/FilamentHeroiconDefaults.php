<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide\Tools;

use Filament\Actions\View\ActionsIconAlias;
use Filament\Forms\View\FormsIconAlias;
use Filament\Infolists\View\InfolistsIconAlias;
use Filament\Notifications\View\NotificationsIconAlias;
use Filament\QueryBuilder\View\QueryBuilderIconAlias;
use Filament\Schemas\View\SchemaIconAlias;
use Filament\Support\Icons\Heroicon;
use Filament\Support\View\SupportIconAlias;
use Filament\Tables\View\TablesIconAlias;
use Filament\View\PanelsIconAlias;
use Filament\Widgets\View\WidgetsIconAlias;

/**
 * The Heroicon each Filament chrome icon slot falls back to when no override is
 * registered, extracted from Filament's source at the pinned version. Reference
 * data for the icon-map verification page only (`bin/icon-map`) — it shows the
 * "before" beside our Lucide "after" so a maintainer can judge each swap.
 *
 * Not exhaustive by design: slots whose Filament default is a non-Heroicon glyph
 * (the file-upload editor's `fi-*` icons, the GitHub brand SVG) are absent and
 * render with no "before" on the page. This is a maintainer tool, never shipped.
 */
final class FilamentHeroiconDefaults
{
    /**
     * @return array<string, Heroicon>
     */
    public static function map(): array
    {
        return [
            // Actions
            ActionsIconAlias::ACTION_GROUP => Heroicon::EllipsisVertical,
            ActionsIconAlias::CREATE_ACTION_GROUPED => Heroicon::Plus,
            ActionsIconAlias::DELETE_ACTION => Heroicon::Trash,
            ActionsIconAlias::DELETE_ACTION_GROUPED => Heroicon::Trash,
            ActionsIconAlias::DELETE_ACTION_MODAL => Heroicon::OutlinedTrash,
            ActionsIconAlias::DETACH_ACTION => Heroicon::XMark,
            ActionsIconAlias::DETACH_ACTION_MODAL => Heroicon::OutlinedXMark,
            ActionsIconAlias::DISSOCIATE_ACTION => Heroicon::XMark,
            ActionsIconAlias::DISSOCIATE_ACTION_MODAL => Heroicon::OutlinedXMark,
            ActionsIconAlias::EDIT_ACTION => Heroicon::PencilSquare,
            ActionsIconAlias::EDIT_ACTION_GROUPED => Heroicon::PencilSquare,
            ActionsIconAlias::EXPORT_ACTION_GROUPED => Heroicon::ArrowDownTray,
            ActionsIconAlias::FORCE_DELETE_ACTION => Heroicon::Trash,
            ActionsIconAlias::FORCE_DELETE_ACTION_GROUPED => Heroicon::Trash,
            ActionsIconAlias::FORCE_DELETE_ACTION_MODAL => Heroicon::OutlinedTrash,
            ActionsIconAlias::IMPORT_ACTION_GROUPED => Heroicon::ArrowUpTray,
            ActionsIconAlias::MODAL_CONFIRMATION => Heroicon::OutlinedExclamationTriangle,
            ActionsIconAlias::REPLICATE_ACTION => Heroicon::Square2Stack,
            ActionsIconAlias::REPLICATE_ACTION_GROUPED => Heroicon::Square2Stack,
            ActionsIconAlias::RESTORE_ACTION => Heroicon::ArrowUturnLeft,
            ActionsIconAlias::RESTORE_ACTION_GROUPED => Heroicon::ArrowUturnLeft,
            ActionsIconAlias::RESTORE_ACTION_MODAL => Heroicon::OutlinedArrowUturnLeft,
            ActionsIconAlias::VIEW_ACTION => Heroicon::Eye,
            ActionsIconAlias::VIEW_ACTION_GROUPED => Heroicon::Eye,

            // Panels
            PanelsIconAlias::GLOBAL_SEARCH_FIELD => Heroicon::MagnifyingGlass,
            PanelsIconAlias::PAGES_DASHBOARD_ACTIONS_FILTER => Heroicon::Funnel,
            PanelsIconAlias::PAGES_DASHBOARD_NAVIGATION_ITEM => Heroicon::Home,
            PanelsIconAlias::PAGES_PASSWORD_RESET_REQUEST_PASSWORD_RESET_ACTIONS_LOGIN => Heroicon::ArrowLeft,
            PanelsIconAlias::PAGES_PASSWORD_RESET_REQUEST_PASSWORD_RESET_ACTIONS_LOGIN_RTL => Heroicon::ArrowRight,
            PanelsIconAlias::RESOURCES_PAGES_EDIT_RECORD_NAVIGATION_ITEM => Heroicon::OutlinedPencilSquare,
            PanelsIconAlias::RESOURCES_PAGES_MANAGE_RELATED_RECORDS_NAVIGATION_ITEM => Heroicon::OutlinedRectangleStack,
            PanelsIconAlias::RESOURCES_PAGES_VIEW_RECORD_NAVIGATION_ITEM => Heroicon::OutlinedEye,
            PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON => Heroicon::OutlinedChevronLeft,
            PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON_RTL => Heroicon::OutlinedChevronRight,
            PanelsIconAlias::SIDEBAR_EXPAND_BUTTON => Heroicon::OutlinedChevronRight,
            PanelsIconAlias::SIDEBAR_EXPAND_BUTTON_RTL => Heroicon::OutlinedChevronLeft,
            PanelsIconAlias::SIDEBAR_GROUP_COLLAPSE_BUTTON => Heroicon::ChevronUp,
            PanelsIconAlias::SUB_NAVIGATION_MOBILE_MENU_BUTTON => Heroicon::ChevronDown,
            PanelsIconAlias::TENANT_MENU_BILLING_BUTTON => Heroicon::CreditCard,
            PanelsIconAlias::TENANT_MENU_PROFILE_BUTTON => Heroicon::Cog6Tooth,
            PanelsIconAlias::TENANT_MENU_REGISTRATION_BUTTON => Heroicon::Plus,
            PanelsIconAlias::TENANT_MENU_TOGGLE_BUTTON => Heroicon::ChevronDown,
            PanelsIconAlias::THEME_SWITCHER_LIGHT_BUTTON => Heroicon::Sun,
            PanelsIconAlias::THEME_SWITCHER_DARK_BUTTON => Heroicon::Moon,
            PanelsIconAlias::THEME_SWITCHER_SYSTEM_BUTTON => Heroicon::ComputerDesktop,
            PanelsIconAlias::TOPBAR_CLOSE_SIDEBAR_BUTTON => Heroicon::OutlinedXMark,
            PanelsIconAlias::TOPBAR_OPEN_SIDEBAR_BUTTON => Heroicon::OutlinedBars3,
            PanelsIconAlias::TOPBAR_GROUP_TOGGLE_BUTTON => Heroicon::ChevronDown,
            PanelsIconAlias::TOPBAR_OPEN_DATABASE_NOTIFICATIONS_BUTTON => Heroicon::OutlinedBell,
            PanelsIconAlias::SIDEBAR_OPEN_DATABASE_NOTIFICATIONS_BUTTON => Heroicon::OutlinedBell,
            PanelsIconAlias::USER_MENU_PROFILE_ITEM => Heroicon::UserCircle,
            PanelsIconAlias::USER_MENU_LOGOUT_BUTTON => Heroicon::ArrowLeftEndOnRectangle,
            PanelsIconAlias::USER_MENU_TOGGLE_BUTTON => Heroicon::ChevronUp,
            PanelsIconAlias::WIDGETS_ACCOUNT_LOGOUT_BUTTON => Heroicon::ArrowLeftEndOnRectangle,
            PanelsIconAlias::WIDGETS_FILAMENT_INFO_OPEN_DOCUMENTATION_BUTTON => Heroicon::BookOpen,

            // Forms
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_CLONE => Heroicon::Square2Stack,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_COLLAPSE => Heroicon::ChevronUp,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_DELETE => Heroicon::Trash,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_EXPAND => Heroicon::ChevronDown,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_MOVE_DOWN => Heroicon::ArrowDown,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_MOVE_UP => Heroicon::ArrowUp,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_REORDER => Heroicon::ArrowsUpDown,
            FormsIconAlias::COMPONENTS_CHECKBOX_LIST_SEARCH_FIELD => Heroicon::MagnifyingGlass,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_MOVE_DOWN => Heroicon::ArrowDownCircle,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_MOVE_LEFT => Heroicon::ArrowLeftCircle,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_MOVE_RIGHT => Heroicon::ArrowRightCircle,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_MOVE_UP => Heroicon::ArrowUpCircle,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ROTATE_LEFT => Heroicon::ArrowUturnLeft,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ROTATE_RIGHT => Heroicon::ArrowUturnRight,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ZOOM_100 => Heroicon::ArrowsPointingOut,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ZOOM_IN => Heroicon::MagnifyingGlassPlus,
            FormsIconAlias::COMPONENTS_FILE_UPLOAD_EDITOR_ACTIONS_ZOOM_OUT => Heroicon::MagnifyingGlassMinus,
            FormsIconAlias::COMPONENTS_KEY_VALUE_ACTIONS_DELETE => Heroicon::Trash,
            FormsIconAlias::COMPONENTS_KEY_VALUE_ACTIONS_REORDER => Heroicon::ArrowsUpDown,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_CLONE => Heroicon::Square2Stack,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_COLLAPSE => Heroicon::ChevronUp,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_DELETE => Heroicon::Trash,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_EXPAND => Heroicon::ChevronDown,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_MOVE_DOWN => Heroicon::ArrowDown,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_MOVE_UP => Heroicon::ArrowUp,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_REORDER => Heroicon::ArrowsUpDown,
            FormsIconAlias::COMPONENTS_RICH_EDITOR_PANELS_CUSTOM_BLOCKS_CLOSE_BUTTON => Heroicon::XMark,
            FormsIconAlias::COMPONENTS_RICH_EDITOR_PANELS_CUSTOM_BLOCK_DELETE_BUTTON => Heroicon::Trash,
            FormsIconAlias::COMPONENTS_RICH_EDITOR_PANELS_CUSTOM_BLOCK_EDIT_BUTTON => Heroicon::PencilSquare,
            FormsIconAlias::COMPONENTS_RICH_EDITOR_PANELS_MERGE_TAGS_CLOSE_BUTTON => Heroicon::XMark,
            FormsIconAlias::COMPONENTS_SELECT_ACTIONS_CREATE_OPTION => Heroicon::Plus,
            FormsIconAlias::COMPONENTS_SELECT_ACTIONS_EDIT_OPTION => Heroicon::PencilSquare,
            FormsIconAlias::COMPONENTS_TEXT_INPUT_ACTIONS_COPY => Heroicon::ClipboardDocumentList,
            FormsIconAlias::COMPONENTS_TEXT_INPUT_ACTIONS_HIDE_PASSWORD => Heroicon::EyeSlash,
            FormsIconAlias::COMPONENTS_TEXT_INPUT_ACTIONS_SHOW_PASSWORD => Heroicon::Eye,
            FormsIconAlias::COMPONENTS_TOGGLE_BUTTONS_BOOLEAN_FALSE => Heroicon::XMark,
            FormsIconAlias::COMPONENTS_TOGGLE_BUTTONS_BOOLEAN_TRUE => Heroicon::Check,

            // Infolists
            InfolistsIconAlias::COMPONENTS_ICON_ENTRY_FALSE => Heroicon::OutlinedXCircle,
            InfolistsIconAlias::COMPONENTS_ICON_ENTRY_TRUE => Heroicon::OutlinedCheckCircle,

            // Notifications
            NotificationsIconAlias::DATABASE_MODAL_EMPTY_STATE => Heroicon::OutlinedBellSlash,
            NotificationsIconAlias::NOTIFICATION_CLOSE_BUTTON => Heroicon::XMark,
            NotificationsIconAlias::NOTIFICATION_DANGER => Heroicon::OutlinedXCircle,
            NotificationsIconAlias::NOTIFICATION_INFO => Heroicon::OutlinedInformationCircle,
            NotificationsIconAlias::NOTIFICATION_SUCCESS => Heroicon::OutlinedCheckCircle,
            NotificationsIconAlias::NOTIFICATION_WARNING => Heroicon::OutlinedExclamationCircle,

            // Query builder
            QueryBuilderIconAlias::ADD_RULE_ACTION => Heroicon::Plus,
            QueryBuilderIconAlias::CONSTRAINTS_BOOLEAN => Heroicon::CheckCircle,
            QueryBuilderIconAlias::CONSTRAINTS_DATE => Heroicon::Calendar,
            QueryBuilderIconAlias::CONSTRAINTS_NUMBER => Heroicon::Variable,
            QueryBuilderIconAlias::CONSTRAINTS_RELATIONSHIP => Heroicon::ArrowsPointingOut,
            QueryBuilderIconAlias::CONSTRAINTS_SELECT => Heroicon::ChevronUpDown,
            QueryBuilderIconAlias::CONSTRAINTS_TEXT => Heroicon::Language,
            QueryBuilderIconAlias::OR_GROUP_BLOCK => Heroicon::Slash,
            QueryBuilderIconAlias::OR_GROUP_ADD_GROUP_ACTION => Heroicon::Plus,

            // Schema
            SchemaIconAlias::COMPONENTS_CALLOUT_DANGER => Heroicon::OutlinedXCircle,
            SchemaIconAlias::COMPONENTS_CALLOUT_INFO => Heroicon::OutlinedInformationCircle,
            SchemaIconAlias::COMPONENTS_CALLOUT_SUCCESS => Heroicon::OutlinedCheckCircle,
            SchemaIconAlias::COMPONENTS_CALLOUT_WARNING => Heroicon::OutlinedExclamationCircle,
            SchemaIconAlias::COMPONENTS_TABS_DROPDOWN_TRIGGER_BUTTON => Heroicon::ChevronDown,
            SchemaIconAlias::COMPONENTS_TABS_MORE_TABS_BUTTON => Heroicon::EllipsisHorizontal,
            SchemaIconAlias::COMPONENTS_WIZARD_COMPLETED_STEP => Heroicon::OutlinedCheck,

            // Support
            SupportIconAlias::BADGE_DELETE_BUTTON => Heroicon::XMark,
            SupportIconAlias::BREADCRUMBS_SEPARATOR => Heroicon::ChevronRight,
            SupportIconAlias::BREADCRUMBS_SEPARATOR_RTL => Heroicon::ChevronLeft,
            SupportIconAlias::MODAL_CLOSE_BUTTON => Heroicon::OutlinedXMark,
            SupportIconAlias::PAGINATION_FIRST_BUTTON => Heroicon::ChevronDoubleLeft,
            SupportIconAlias::PAGINATION_FIRST_BUTTON_RTL => Heroicon::ChevronDoubleRight,
            SupportIconAlias::PAGINATION_LAST_BUTTON => Heroicon::ChevronDoubleRight,
            SupportIconAlias::PAGINATION_LAST_BUTTON_RTL => Heroicon::ChevronDoubleLeft,
            SupportIconAlias::PAGINATION_NEXT_BUTTON => Heroicon::ChevronRight,
            SupportIconAlias::PAGINATION_NEXT_BUTTON_RTL => Heroicon::ChevronLeft,
            SupportIconAlias::PAGINATION_PREVIOUS_BUTTON => Heroicon::ChevronLeft,
            SupportIconAlias::PAGINATION_PREVIOUS_BUTTON_RTL => Heroicon::ChevronRight,
            SupportIconAlias::SECTION_COLLAPSE_BUTTON => Heroicon::ChevronUp,

            // Tables
            TablesIconAlias::ACTIONS_DISABLE_REORDERING => Heroicon::Check,
            TablesIconAlias::ACTIONS_ENABLE_REORDERING => Heroicon::Check,
            TablesIconAlias::ACTIONS_FILTER => Heroicon::Funnel,
            TablesIconAlias::ACTIONS_GROUP => Heroicon::RectangleStack,
            TablesIconAlias::ACTIONS_OPEN_BULK_ACTIONS => Heroicon::EllipsisVertical,
            TablesIconAlias::ACTIONS_COLUMN_MANAGER => Heroicon::ViewColumns,
            TablesIconAlias::COLUMNS_COLLAPSE_BUTTON => Heroicon::ChevronDown,
            TablesIconAlias::COLUMNS_ICON_COLUMN_FALSE => Heroicon::OutlinedXCircle,
            TablesIconAlias::COLUMNS_ICON_COLUMN_TRUE => Heroicon::OutlinedCheckCircle,
            TablesIconAlias::EMPTY_STATE => Heroicon::OutlinedXMark,
            TablesIconAlias::FILTERS_REMOVE_ALL_BUTTON => Heroicon::XMark,
            TablesIconAlias::GROUPING_COLLAPSE_BUTTON => Heroicon::ChevronUp,
            TablesIconAlias::HEADER_CELL_SORT_ASC_BUTTON => Heroicon::ChevronUp,
            TablesIconAlias::HEADER_CELL_SORT_BUTTON => Heroicon::ChevronDown,
            TablesIconAlias::HEADER_CELL_SORT_DESC_BUTTON => Heroicon::ChevronDown,
            TablesIconAlias::REORDER_HANDLE => Heroicon::Bars2,
            TablesIconAlias::SEARCH_FIELD => Heroicon::MagnifyingGlass,

            // Widgets
            WidgetsIconAlias::CHART_WIDGET_FILTER => Heroicon::Funnel,
        ];
    }
}
