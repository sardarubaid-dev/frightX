<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('styles')
    <x-list-styles />
    <style>
        /* 100% PIXEL-PERFECT MATCH FOR OCEAN IMPORT TODO LIST SETTINGS */
        [x-cloak] { display: none !important; }

        body {
            background-color: #f8fafc;
            color: #2d3748;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .page-bar {
            background-color: #fff;
            padding: 10px 20px;
            margin-bottom: 15px;
            border: 1px solid #e9ebec;
            border-radius: 4px;
        }

        .page-breadcrumb {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .page-breadcrumb li {
            font-size: 13px;
            color: #888;
            display: flex;
            align-items: center;
        }

        .page-breadcrumb li a {
            color: #337ab7;
            text-decoration: none;
        }

        .page-breadcrumb li a:hover {
            color: #1d4ed8;
        }

        .page-breadcrumb li i {
            margin: 0 8px;
            font-size: 11px;
            opacity: 0.5;
        }

        .todo-main-wrapper {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
            overflow: hidden;
        }

        /* TOOLBAR TABS & BUTTONS */
        .todo-toolbar {
            background: #fafafa;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .todo-tab-btn {
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 500;
            height: 32px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .todo-tab-btn:first-child { border-radius: 4px 0 0 4px; }
        .todo-tab-btn:not(:first-child) { border-left: none; }
        .todo-tab-btn:last-child { border-radius: 0 4px 4px 0; }

        .todo-tab-btn:hover { background: #f1f5f9; color: #1e293b; }

        .todo-tab-btn.active {
            background: #2bcfd4 !important;
            color: #fff !important;
            border-color: #2bcfd4 !important;
            font-weight: 600;
        }

        .btn-plus-tab {
            background: #2bcfd4;
            color: #fff;
            border: none;
            padding: 6px 14px;
            height: 32px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-left: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 3px rgba(43, 207, 212, 0.25);
            transition: all 0.15s ease;
        }

        .btn-plus-tab:hover {
            background: #22b6bb;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(43, 207, 212, 0.35);
        }

        .btn-config-gear {
            background: #64748b;
            color: #fff;
            border: none;
            padding: 6px 14px;
            height: 32px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
        }

        .btn-config-gear:hover { background: #475569; }

        /* TWO COLUMN CONTAINER */
        .todo-split-container {
            display: flex;
            min-height: 650px;
        }

        /* LEFT PANEL */
        .todo-left-panel {
            width: 44%;
            border-right: 1px solid #e2e8f0;
            padding: 16px 20px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .todo-card-list {
            overflow-y: auto;
            max-height: calc(100vh - 280px);
            padding-right: 6px;
        }

        /* TASK CARD ITEM */
        .todo-card-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 14px 16px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .todo-card-item:hover {
            border-color: #cbd5e1;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .todo-card-item.active {
            border-color: #cbd5e1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            background: #ffffff;
        }

        .todo-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .todo-card-title {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
            line-height: 1.3;
        }

        .todo-card-subtitle {
            font-size: 12px;
            color: #a0aec0;
            margin: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .todo-card-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #cbd5e0;
            font-size: 13px;
        }

        .todo-card-actions i {
            cursor: pointer;
            padding: 3px 5px;
            border-radius: 3px;
            transition: all 0.15s ease;
        }

        .todo-card-actions i:hover {
            color: #2bcfd4;
            background: #f1f5f9;
        }

        .todo-card-actions i.fa-times:hover {
            color: #ef4444;
            background: #fef2f2;
        }

        /* CENTER TEAL PILL SAVE BUTTON */
        .left-panel-footer {
            padding-top: 15px;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            margin-top: 10px;
        }

        .btn-teal-pill-save {
            background: #2bcfd4;
            color: #fff;
            border: none;
            border-radius: 9999px;
            padding: 10px 52px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(43, 207, 212, 0.35);
            transition: all 0.2s ease;
            display: inline-block;
            outline: none;
        }

        .btn-teal-pill-save:hover {
            background: #22b6bb;
            box-shadow: 0 6px 18px rgba(43, 207, 212, 0.45);
            transform: translateY(-1px);
        }

        .btn-teal-pill-save:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(43, 207, 212, 0.3);
        }

        /* RIGHT PANEL WORKFLOW CONFIGURATOR */
        .todo-right-panel {
            width: 56%;
            padding: 24px 28px;
            background: #fff;
            overflow-y: auto;
        }

        /* SECTIONS CARDS */
        .section-card {
            border-radius: 6px;
            padding: 18px 20px;
            margin-bottom: 18px;
            position: relative;
        }

        .section-card.start-card {
            background: #fff;
            border: 1px solid #e2e8f0;
        }

        .section-card.condition-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .section-card.action-card {
            background: #f0f9ff;
            border: 1px solid #e0f2fe;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 16px;
        }

        .section-header.teal {
            color: #2bcfd4;
        }

        .section-header .header-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-header .close-card-btn {
            color: #4a5568;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            transition: all 0.15s ease;
        }

        .section-header .close-card-btn:hover {
            color: #ef4444;
            background: #fef2f2;
        }

        /* INPUTS & SELECTS FORM STYLES */
        .rule-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .rule-row:last-child {
            margin-bottom: 0;
        }

        .rule-label-wording {
            font-size: 13px;
            color: #a0aec0;
            min-width: 16px;
        }

        .rule-select,
        .rule-input {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 13px;
            color: #4a5568;
            background: #fff;
            outline: none;
            transition: border-color 0.15s ease;
            height: 36px;
            box-sizing: border-box;
        }

        .rule-select:focus,
        .rule-input:focus {
            border-color: #2bcfd4;
        }

        .rule-row-remove {
            color: #cbd5e0;
            font-size: 14px;
            cursor: pointer;
            padding: 4px;
            border-radius: 3px;
            transition: all 0.15s ease;
        }

        .rule-row-remove:hover {
            color: #ef4444;
            background: #fef2f2;
        }

        .link-add-sub {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 12px;
            cursor: pointer;
            transition: color 0.15s ease;
            padding: 2px 0;
        }

        .link-add-sub:hover {
            color: #2bcfd4;
        }

        /* CONNECTORS BETWEEN CARDS */
        .connector-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 18px 0;
            position: relative;
        }

        .connector-line {
            flex: 1;
            height: 1px;
            background: #edf2f7;
        }

        .connector-text {
            padding: 0 16px;
            font-size: 12px;
            color: #a0aec0;
            font-weight: 500;
        }

        /* CENTER ACTION BUTTONS */
        .btn-teal-action-center {
            background: #2bcfd4;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 7px 18px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: 0 2px 5px rgba(43, 207, 212, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            outline: none;
        }

        .btn-teal-action-center:hover {
            background: #22b6bb;
            box-shadow: 0 4px 8px rgba(43, 207, 212, 0.35);
            transform: translateY(-1px);
        }

        .btn-teal-action-center:active {
            transform: translateY(0);
        }

        /* TOAST STYLING */
        .toast-container {
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: #1e293b;
            color: #fff;
            padding: 12px 18px;
            border-radius: 4px;
            font-size: 13px;
            min-width: 240px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toast.success { border-left: 4px solid #22c55e; }
        .toast.error { border-left: 4px solid #ef4444; }
        .toast.info { border-left: 4px solid #3b82f6; }

        /* FULL 100% RESPONSIVE BREAKPOINTS */
        @media (max-width: 992px) {
            .todo-split-container {
                flex-direction: column !important;
                min-height: auto !important;
            }

            .todo-left-panel {
                width: 100% !important;
                border-right: none !important;
                border-bottom: 1px solid #e2e8f0 !important;
                padding: 16px !important;
            }

            .todo-card-list {
                max-height: 300px !important;
            }

            .todo-right-panel {
                width: 100% !important;
                padding: 18px 16px !important;
            }

            .rule-row {
                flex-wrap: wrap !important;
                gap: 8px !important;
            }

            .rule-select, .rule-input {
                max-width: 100% !important;
                box-sizing: border-box !important;
            }
        }

        @media (max-width: 768px) {
            .todo-toolbar {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 10px !important;
                padding: 10px 14px !important;
            }

            .todo-toolbar > div:first-child {
                width: 100% !important;
                overflow-x: auto !important;
                padding-bottom: 4px !important;
                justify-content: flex-start !important;
            }

            .todo-tab-btn {
                flex-shrink: 0 !important;
                padding: 6px 12px !important;
                font-size: 12px !important;
            }

            .btn-plus-tab {
                flex-shrink: 0 !important;
            }

            .todo-toolbar > div:last-child {
                display: flex !important;
                justify-content: flex-end !important;
                width: 100% !important;
            }

            .btn-config-gear {
                width: 100% !important;
                justify-content: center !important;
            }

            .rule-row select, .rule-row input {
                width: 100% !important;
                flex: 1 1 100% !important;
            }

            .section-card {
                padding: 14px 12px !important;
            }
        }

        @media (max-width: 576px) {
            .btn-teal-pill-save {
                width: 100% !important;
                padding: 10px 20px !important;
            }

            .page-bar {
                padding: 8px 12px !important;
            }
        }
    </style>
    @endpush

    {{-- Toast Container --}}
    <div class="toast-container" id="toast-container"></div>

    <!-- Breadcrumb -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="/settings">Settings</a> <i class="fa fa-angle-right"></i></li>
            <li><span style="color: #333; font-weight: 700;">To Do List Setting</span></li>
        </ul>
    </div>

    <!-- Main Container -->
    <div class="todo-main-wrapper" x-data="todoListApp()" x-init="init()">

        <!-- Header Toolbar -->
        <div class="todo-toolbar">
            <div style="display:flex;align-items:center;">
                <div style="display:flex;">
                    <template x-for="tab in tabs" :key="tab.id">
                        <button class="todo-tab-btn" 
                                :class="{ 'active': currentModule === tab.id }" 
                                @click="switchModule(tab.id)"
                                x-text="tab.label">
                        </button>
                    </template>
                </div>
                <button class="btn-plus-tab" @click="addTask()" title="Add New Workflow">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div>
                <button type="button" class="btn-config-gear" @click.stop.prevent="openConfigModal()">
                    <i class="fa fa-cogs"></i> Config
                </button>
            </div>
        </div>

        <!-- Two-Column Layout -->
        <div class="todo-split-container">

            <!-- LEFT PANEL: WORKFLOW CARDS LIST -->
            <div class="todo-left-panel">
                <div class="todo-card-list">
                    <template x-for="task in tasks" :key="task.id">
                        <div class="todo-card-item" 
                             :class="{ 'active': selectedTaskId === task.id }"
                             @click="selectTask(task.id)">
                            <div class="todo-card-header">
                                <h4 class="todo-card-title" x-text="task.title || 'Untitled Workflow'"></h4>
                                <div class="todo-card-actions">
                                    <i class="fa fa-files-o" @click.stop="duplicateTask(task.id)" title="Duplicate"></i>
                                    <i class="fa fa-times" @click.stop="deleteTask(task.id)" title="Delete"></i>
                                </div>
                            </div>
                            <p class="todo-card-subtitle" x-text="task.description || getSubtitle(task)"></p>
                        </div>
                    </template>

                    <div x-show="tasks.length === 0" style="text-align:center;padding:50px 20px;color:#a0aec0;">
                        <i class="fa fa-inbox" style="font-size:42px;display:block;margin-bottom:12px;opacity:0.4;"></i>
                        <p style="font-size:13px;margin:0;">No workflows in this module</p>
                    </div>
                </div>

                <div class="left-panel-footer">
                    <button type="button" class="btn-teal-pill-save" @click="saveCurrentTask()">Save</button>
                </div>
            </div>

            <!-- RIGHT PANEL: WORKFLOW RULE CONFIGURATOR -->
            <template x-if="activeTask">
                <div class="todo-right-panel">

                    <!-- WORKFLOW TITLE HEADER -->
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:10px;border-bottom:1px solid #edf2f7;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <input type="text" x-model="activeTask.title" 
                                   style="font-size:16px;font-weight:700;color:#2d3748;border:none;border-bottom:1px dashed #cbd5e1;background:transparent;padding:2px 4px;outline:none;" 
                                   placeholder="Workflow Title">
                            <i class="fa fa-pencil" style="color:#a0aec0;font-size:14px;"></i>
                        </div>
                    </div>

                    <!-- SECTION 1: WHEN TO START -->
                    <div class="section-card start-card">
                        <div class="section-header">
                            <div class="header-left">
                                <i class="fa fa-clock-o"></i> When to Start
                            </div>
                        </div>

                        <div class="rule-row">
                            <!-- DAYS SELECT (0 TO 30 DAYS) -->
                            <select class="rule-select" style="width:100px;" x-model="activeTask.config.startDays">
                                <template x-for="d in 31" :key="d-1">
                                    <option :value="d-1" x-text="(d-1) + ' Days'"></option>
                                </template>
                            </select>

                            <!-- BEFORE / AFTER SELECT -->
                            <select class="rule-select" style="width:100px;" x-model="activeTask.config.startDirection">
                                <option value="false">After</option>
                                <option value="true">Before</option>
                            </select>

                            <!-- EXACT FREIGHTX START REFERENCES -->
                            <select class="rule-select" style="flex:1;" x-model="activeTask.config.startReference">
                                <template x-for="ref in startReferences" :key="ref">
                                    <option :value="ref" x-text="ref"></option>
                                </template>
                            </select>
                        </div>

                        <div style="margin-top:12px;">
                            <span class="link-add-sub" @click="toggleSnooze()">
                                <i class="fa fa-plus"></i> Set Snooze days
                            </span>
                            <template x-if="activeTask && activeTask.config && activeTask.config.hasSnooze">
                                <div class="rule-row" style="margin-top:8px;background:#f8fafc;padding:8px 12px;border:1px solid #e2e8f0;border-radius:4px;">
                                    <span style="font-size:12px;color:#4a5568;">Alert again after</span>
                                    <select class="rule-select" style="width:85px;height:30px;padding:4px 8px;" x-model="activeTask.config.snoozeDays">
                                        <option value="1">1 Days</option>
                                        <option value="2">2 Days</option>
                                        <option value="3">3 Days</option>
                                        <option value="5">5 Days</option>
                                    </select>
                                    <span style="font-size:12px;color:#4a5568;">of warning date</span>
                                </div>
                            </template>
                        </div>
                    </div>

                <!-- CONNECTOR 1: AND -->
                <div class="connector-wrap">
                    <div class="connector-line"></div>
                    <div class="connector-text">And</div>
                    <div class="connector-line"></div>
                </div>

                <!-- SECTION 2: CONDITION -->
                <div class="section-card condition-card">
                    <div class="section-header teal">
                        <div class="header-left">
                            <i class="fa fa-filter"></i> Condition
                        </div>
                        <i class="fa fa-times close-card-btn" @click="clearConditions()" title="Reset conditions"></i>
                    </div>

                    <template x-for="(cond, index) in activeTask.config.conditions" :key="index">
                        <div class="rule-row">
                            <span class="rule-label-wording" x-text="index === 0 ? 'If' : 'Or'"></span>
                            
                            <!-- EXACT FREIGHTX CONDITION FIELDS -->
                            <select class="rule-select" style="flex:1;" x-model="cond.field" @change="updateSubtitle()">
                                <template x-for="f in conditionFields" :key="f">
                                    <option :value="f" x-text="f"></option>
                                </template>
                            </select>

                            <!-- EXACT FREIGHTX OPERATORS -->
                            <select class="rule-select" style="width:130px;" x-model="cond.operator">
                                <template x-for="op in conditionOperators" :key="op">
                                    <option :value="op" x-text="op"></option>
                                </template>
                            </select>

                            <i class="fa fa-times rule-row-remove" @click="removeCondition(index)"></i>
                        </div>
                    </template>

                    <div>
                        <span class="link-add-sub" @click="addOrCondition()">
                            <i class="fa fa-plus"></i> "Or" Condition
                        </span>
                    </div>
                </div>

                <!-- CONNECTOR 2: AND CONDITION BUTTON -->
                <div class="connector-wrap">
                    <div class="connector-line"></div>
                    <button type="button" class="btn-teal-action-center" @click="addAndCondition()">
                        <i class="fa fa-plus" style="font-size:11px;"></i> "And" Condition
                    </button>
                    <div class="connector-line"></div>
                </div>

                <!-- SECTION 3: ACTION -->
                <div class="section-card action-card">
                    <div class="section-header teal">
                        <div class="header-left">
                            <i class="fa fa-bolt"></i> Action
                        </div>
                    </div>

                    <template x-for="(act, index) in activeTask.config.actions" :key="index">
                        <div class="rule-row">
                            <span style="width:150px;font-size:12px;color:#4a5568;font-weight:500;" x-text="act.label"></span>
                            <input type="text" class="rule-input" style="flex:1;" :placeholder="act.placeholder || 'Customize the Message if you need (Optional)'" x-model="act.value">
                        </div>
                    </template>
                </div>

                <!-- CONNECTOR 3: ACTION BUTTON -->
                <div class="connector-wrap">
                    <div class="connector-line"></div>
                    <button type="button" class="btn-teal-action-center" @click="addAction()">
                        <i class="fa fa-plus" style="font-size:11px;"></i> Action
                    </button>
                    <div class="connector-line"></div>
                </div>

                </div>
            </template>

            <!-- Empty Right Panel Placeholder -->
            <template x-if="!activeTask">
                <div class="todo-right-panel" style="display:flex;align-items:center;justify-content:center;color:#a0aec0;">
                    <div style="text-align:center;">
                        <i class="fa fa-hand-pointer-o" style="font-size:42px;display:block;margin-bottom:12px;opacity:0.3;"></i>
                        <p style="font-size:14px;margin:0;">Select a workflow card to configure rules</p>
                    </div>
                </div>
            </template>

        </div>

        {{-- Task Sequence Configuration Modal --}}
        <template x-if="showConfigModal">
            <div class="todo-modal-overlay" 
                 style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(15,23,42,0.65);backdrop-filter:blur(3px);z-index:999999;display:flex;align-items:center;justify-content:center;padding:16px;"
                 @click.self="showConfigModal = false">
                <div class="todo-modal-box" style="background:#fff;border-radius:8px;width:100%;max-width:540px;box-shadow:0 20px 40px rgba(0,0,0,0.35);overflow:hidden;display:flex;flex-direction:column;max-height:85vh;margin:auto;">
                    {{-- Modal Header --}}
                    <div style="padding:16px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;background:#f8fafc;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <i class="fa fa-cogs" style="color:#2bcfd4;font-size:16px;"></i>
                            <h4 style="margin:0;font-size:15px;font-weight:700;color:#1e293b;">Task Sequence Configuration</h4>
                        </div>
                        <i class="fa fa-times" style="font-size:16px;color:#94a3b8;cursor:pointer;padding:4px;" @click="showConfigModal = false" title="Close"></i>
                    </div>
                    
                    {{-- Modal Body --}}
                    <div style="padding:20px;overflow-y:auto;background:#fff;flex:1;">
                        <p style="font-size:12px;color:#64748b;margin:0 0 14px 0;">Enable/disable tasks or reorder workflow sequence for <strong style="color:#0f172a;" x-text="getCurrentModuleLabel()"></strong>:</p>
                        
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <template x-for="(tItem, idx) in configModalTasks" :key="tItem.id || idx">
                                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;transition:all 0.15s ease;">
                                    <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
                                        <input type="checkbox" x-model="tItem.is_active" style="width:18px;height:18px;accent-color:#2bcfd4;cursor:pointer;flex-shrink:0;">
                                        <span style="font-size:13px;font-weight:600;color:#334155;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" x-text="tItem.title"></span>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                                        <button type="button" @click="moveConfigTaskUp(idx)" :disabled="idx === 0" style="background:#fff;border:1px solid #cbd5e1;color:#475569;cursor:pointer;padding:4px 8px;border-radius:4px;font-size:11px;" title="Move Up">
                                            <i class="fa fa-chevron-up"></i>
                                        </button>
                                        <button type="button" @click="moveConfigTaskDown(idx)" :disabled="idx === configModalTasks.length - 1" style="background:#fff;border:1px solid #cbd5e1;color:#475569;cursor:pointer;padding:4px 8px;border-radius:4px;font-size:11px;" title="Move Down">
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <div x-show="!configModalTasks || configModalTasks.length === 0" style="text-align:center;padding:30px;color:#94a3b8;">
                                No tasks found in this module.
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div style="padding:14px 20px;border-top:1px solid #e2e8f0;background:#f8fafc;display:flex;align-items:center;justify-content:flex-end;gap:12px;">
                        <button type="button" @click="showConfigModal = false" style="background:#e2e8f0;color:#475569;border:none;padding:8px 22px;border-radius:4px;font-size:13px;font-weight:600;cursor:pointer;">Cancel</button>
                        <button type="button" @click="applyTaskSequence()" style="background:#2bcfd4;color:#fff;border:none;padding:8px 26px;border-radius:4px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 2px 6px rgba(43,207,212,0.35);">Apply</button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Alpine.js Logic -->
    <script>
    function todoListApp() {
        return {
            csrfToken: document.querySelector('meta[name="csrf-token"]').content,
            currentModule: 'ocean-import',
            tabs: [
                { id: 'ocean-import', label: 'Ocean Import' },
                { id: 'ocean-export', label: 'Ocean Export' },
                { id: 'air-import', label: 'Air Import' },
                { id: 'air-export', label: 'Air Export' }
            ],

            // EXACT EXTRACTED FREIGHTX START REFERENCES
            startReferences: [
                "HBL: Arrival Notice Saved Date (Doc Center)",
                "HBL: Available",
                "HBL: C. Released Date",
                "HBL: Door Delivered",
                "HBL: Expiry Date",
                "HBL: Final ETA",
                "HBL: Frt. Released",
                "HBL: G.O Date",
                "HBL: IT Date",
                "HBL: LFD",
                "HBL: OB/L Received",
                "HBL: Place of Delivery ETA",
                "MBL: ETA",
                "MBL: ETD",
                "MBL: Final ETA",
                "MBL: IT Date",
                "MBL: OB/L Received",
                "MBL: Place of Delivery ETA",
                "MBL: Place of Receipt ETD",
                "MBL: Post Date",
                "MBL: Released Date"
            ],

            // EXACT EXTRACTED FREIGHTX CONDITION FIELDS
            conditionFields: [
                "HBL: (Express) OB/L received",
                "HBL: AMS No.",
                "HBL: AP",
                "HBL: AR",
                "HBL: Arrival Notice Saved",
                "HBL: Arrival Notice Saved Date (Doc Center)",
                "HBL: Arrival Notice Sent",
                "HBL: Available",
                "HBL: Bill To",
                "HBL: C. Released Date",
                "HBL: C.Clearance",
                "HBL: C.Hold",
                "HBL: Cargo Type",
                "HBL: Consignee",
                "HBL: Customer",
                "HBL: Customs Broker",
                "HBL: CY/CFS Location",
                "HBL: DC",
                "HBL: Delivery Location",
                "HBL: Delivery Order Saved",
                "HBL: Delivery Order Sent",
                "HBL: Door Delivered",
                "HBL: Door Move",
                "HBL: E-Commerce",
                "HBL: Expiry Date",
                "HBL: Express B/L",
                "HBL: Final Destination",
                "HBL: Final ETA",
                "HBL: Freight",
                "HBL: Frt. Released (Check)",
                "HBL: Frt. Released (Date)",
                "HBL: G.O Date",
                "HBL: Has Invoice (A/R) or Debit Note",
                "HBL: Hold",
                "HBL: Incoterms",
                "HBL: ISF Filing by 3rd Party",
                "HBL: ISF Matched",
                "HBL: ISF No.",
                "HBL: IT Date",
                "HBL: IT Issued Location",
                "HBL: IT No.",
                "HBL: LFD",
                "HBL: Need Container Pickup Number",
                "HBL: Notify",
                "HBL: OB/L Received (Check)",
                "HBL: OB/L Received (Date)",
                "HBL: Place of Delivery (DEL)",
                "HBL: Place of Delivery ETA",
                "HBL: Proof of Delivery Sent",
                "HBL: Quotation No.",
                "HBL: Rail",
                "HBL: Release Order Sent",
                "HBL: ROR",
                "HBL: Sales Type",
                "HBL: Service Term From",
                "HBL: Service Term To",
                "HBL: Ship Mode",
                "HBL: Shipper",
                "HBL: Sub B/L No.",
                "HBL: svc_term_to_door",
                "HBL: Telex release received",
                "HBL: Trucker",
                "MBL: Agent Ref No.",
                "MBL: AP",
                "MBL: AR",
                "MBL: B/L Acct. Carrier",
                "MBL: Business Referred By",
                "MBL: Carrier",
                "MBL: CFS Location",
                "MBL: Co-loader",
                "MBL: CY Location",
                "MBL: DC",
                "MBL: Direct Master",
                "MBL: Direct Master Bill To",
                "MBL: Direct Master Cargo type",
                "MBL: Direct Master Consignee",
                "MBL: Direct Master Customer",
                "MBL: Direct Master Customer Ref. No.",
                "MBL: Direct Master Notify",
                "MBL: Direct Master Sales Type",
                "MBL: Direct Master Shipper",
                "MBL: E-Commerce",
                "MBL: ETA",
                "MBL: ETD",
                "MBL: Final Destination",
                "MBL: Final ETA",
                "MBL: Freight",
                "MBL: IT Date",
                "MBL: IT Issued Location",
                "MBL: IT No.",
                "MBL: OB/L Received (Check)",
                "MBL: OB/L Received (Date)",
                "MBL: OB/L Type",
                "MBL: original_bill_of_lading is not released",
                "MBL: Oversea Agent",
                "MBL: Place of Delivery (DEL)",
                "MBL: Place of Delivery ETA",
                "MBL: Place of Receipt",
                "MBL: Place of Receipt ETD",
                "MBL: Port of Discharge",
                "MBL: Port of Loading",
                "MBL: Post Date",
                "MBL: Released Date (Check)",
                "MBL: Released Date (Date)",
                "MBL: Return Location",
                "MBL: Service Term From",
                "MBL: Service Term To",
                "MBL: Ship Mode",
                "MBL: Sub B/L No.",
                "MBL: Vessel",
                "MBL: Voyage"
            ],

            // EXACT EXTRACTED FREIGHTX CONDITION OPERATORS
            conditionOperators: [
                "true",
                "false",
                "is filled",
                "is not filled",
                "is not saved to doc center",
                "is not released"
            ],

            tasks: [],
            selectedTaskId: null,
            activeTask: null,
            showConfigModal: false,
            configModalTasks: [],

            init() {
                this.loadTasks();
            },

            loadTasks() {
                fetch('/api/todo-tasks?module=' + this.currentModule)
                    .then(res => res.json())
                    .then(data => {
                        this.tasks = data.tasks || data;
                        if (this.tasks.length > 0) {
                            this.selectTask(this.tasks[0].id);
                        } else {
                            this.selectedTaskId = null;
                            this.activeTask = null;
                        }
                    })
                    .catch(err => {
                        console.error('Error loading tasks:', err);
                        this.showToast('error', 'Failed to load workflows');
                    });
            },

            switchModule(moduleId) {
                this.currentModule = moduleId;
                this.selectedTaskId = null;
                this.activeTask = null;
                this.loadTasks();
            },

            selectTask(taskId) {
                this.selectedTaskId = taskId;
                const found = this.tasks.find(t => t.id === taskId);
                if (!found) return;

                const task = JSON.parse(JSON.stringify(found));
                if (!task.config) task.config = {};
                if (task.config.startDays === undefined) task.config.startDays = 0;
                if (task.config.startDirection === undefined) task.config.startDirection = 'false'; // false = After, true = Before
                if (!task.config.startReference) task.config.startReference = 'HBL: Arrival Notice Saved Date (Doc Center)';

                if (!task.config.conditions || task.config.conditions.length === 0) {
                    task.config.conditions = [
                        { field: 'HBL: (Express) OB/L received', operator: 'true', value: '' }
                    ];
                }

                if (!task.config.actions || task.config.actions.length === 0) {
                    task.config.actions = [
                        { type: 'mbl_notification', label: 'Show MBL Notification', placeholder: 'Customize the Message if you need (Optional)', value: '' },
                        { type: 'hbl_notification', label: 'Show HBL Notification', placeholder: 'Customize the Message if you need (Optional)', value: '' }
                    ];
                }

                this.activeTask = task;
            },

            updateSubtitle() {
                if (!this.activeTask) return;
                const fields = this.activeTask.config.conditions.map(c => c.field).join(', ');
                this.activeTask.description = '[HB/L] ' + fields;
                
                const localTask = this.tasks.find(t => t.id === this.selectedTaskId);
                if (localTask) {
                    localTask.description = this.activeTask.description;
                }
            },

            getSubtitle(task) {
                if (task.description) return task.description;
                if (task.config && task.config.conditions && task.config.conditions.length > 0) {
                    return '[HB/L] ' + task.config.conditions.map(c => c.field).join(', ');
                }
                return '[HB/L] Workflow Config';
            },

            toggleSnooze() {
                if (!this.activeTask) return;
                if (!this.activeTask.config) this.activeTask.config = {};
                this.activeTask.config.hasSnooze = !this.activeTask.config.hasSnooze;
                if (this.activeTask.config.hasSnooze && !this.activeTask.config.snoozeDays) {
                    this.activeTask.config.snoozeDays = 1;
                }
            },

            addOrCondition() {
                if (!this.activeTask) return;
                this.activeTask.config.conditions.push({
                    field: 'HBL: Actual Shipper',
                    operator: 'is filled',
                    value: ''
                });
                this.updateSubtitle();
            },

            addAndCondition() {
                this.addOrCondition();
                this.showToast('info', 'Condition added');
            },

            removeCondition(index) {
                if (!this.activeTask) return;
                if (this.activeTask.config.conditions.length > 1) {
                    this.activeTask.config.conditions.splice(index, 1);
                    this.updateSubtitle();
                } else {
                    this.showToast('info', 'Requires at least one condition');
                }
            },

            clearConditions() {
                if (!this.activeTask) return;
                this.activeTask.config.conditions = [
                    { field: 'HBL: (Express) OB/L received', operator: 'true', value: '' }
                ];
                this.updateSubtitle();
            },

            addAction() {
                if (!this.activeTask) return;
                this.activeTask.config.actions.push({
                    type: 'custom_notification',
                    label: 'Show Notification',
                    placeholder: 'Customize the Message if you need (Optional)',
                    value: ''
                });
            },

            saveCurrentTask() {
                if (!this.activeTask) {
                    this.showToast('error', 'No workflow selected');
                    return;
                }

                const payload = {
                    module: this.currentModule,
                    title: this.activeTask.title,
                    description: this.activeTask.description || this.getSubtitle(this.activeTask),
                    config: this.activeTask.config
                };

                const url = this.activeTask.id ? `/api/todo-tasks/${this.activeTask.id}` : '/api/todo-tasks';
                const method = this.activeTask.id ? 'PUT' : 'POST';

                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    this.showToast('success', 'Workflow saved successfully');
                    this.loadTasks();
                })
                .catch(err => {
                    console.error('Save error:', err);
                    this.showToast('error', 'Failed to save workflow');
                });
            },

            addTask() {
                const newTask = {
                    module: this.currentModule,
                    title: 'New Workflow',
                    description: '[HB/L] (Express) OB/L received',
                    config: {
                        startDays: 0,
                        startDirection: 'false',
                        startReference: 'HBL: Arrival Notice Saved Date (Doc Center)',
                        conditions: [
                            { field: 'HBL: (Express) OB/L received', operator: 'true', value: '' }
                        ],
                        actions: [
                            { type: 'mbl_notification', label: 'Show MBL Notification', placeholder: 'Customize the Message if you need (Optional)', value: '' },
                            { type: 'hbl_notification', label: 'Show HBL Notification', placeholder: 'Customize the Message if you need (Optional)', value: '' }
                        ]
                    }
                };

                fetch('/api/todo-tasks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    body: JSON.stringify(newTask)
                })
                .then(res => res.json())
                .then(data => {
                    this.showToast('success', 'New workflow created');
                    this.loadTasks();
                    if (data.id) {
                        setTimeout(() => this.selectTask(data.id), 200);
                    }
                })
                .catch(err => {
                    console.error('Error adding task:', err);
                    this.showToast('error', 'Failed to create workflow');
                });
            },

            duplicateTask(taskId) {
                const task = this.tasks.find(t => t.id === taskId);
                if (!task) return;

                const duplicated = {
                    module: this.currentModule,
                    title: task.title + ' (Copy)',
                    description: task.description,
                    config: task.config
                };

                fetch('/api/todo-tasks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    body: JSON.stringify(duplicated)
                })
                .then(res => res.json())
                .then(data => {
                    this.showToast('success', 'Workflow duplicated');
                    this.loadTasks();
                    if (data.id) {
                        setTimeout(() => this.selectTask(data.id), 200);
                    }
                })
                .catch(err => {
                    console.error('Error duplicating task:', err);
                    this.showToast('error', 'Failed to duplicate workflow');
                });
            },

            deleteTask(taskId) {
                if (!confirm('Are you sure you want to delete this workflow?')) return;

                fetch(`/api/todo-tasks/${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.showToast('success', 'Workflow deleted');
                    this.selectedTaskId = null;
                    this.activeTask = null;
                    this.loadTasks();
                })
                .catch(err => {
                    console.error('Error deleting task:', err);
                    this.showToast('error', 'Failed to delete workflow');
                });
            },

            getCurrentModuleLabel() {
                const tab = this.tabs.find(t => t.id === this.currentModule);
                return tab ? tab.label : this.currentModule;
            },

            openConfigModal() {
                console.log('[TodoList] Config button clicked. Current tasks:', this.tasks);
                this.configModalTasks = JSON.parse(JSON.stringify(this.tasks || []));
                this.configModalTasks.forEach(t => {
                    t.is_active = Boolean(t.is_active);
                });
                this.showConfigModal = true;
                console.log('[TodoList] showConfigModal set to true. Tasks in modal:', this.configModalTasks);
            },

            moveConfigTaskUp(idx) {
                if (idx <= 0) return;
                const list = [...this.configModalTasks];
                const temp = list[idx];
                list[idx] = list[idx - 1];
                list[idx - 1] = temp;
                this.configModalTasks = list;
            },

            moveConfigTaskDown(idx) {
                if (idx >= this.configModalTasks.length - 1) return;
                const list = [...this.configModalTasks];
                const temp = list[idx];
                list[idx] = list[idx + 1];
                list[idx + 1] = temp;
                this.configModalTasks = list;
            },

            applyTaskSequence() {
                this.configModalTasks.forEach((t, i) => {
                    t.order = i + 1;
                    t.is_active = Boolean(t.is_active);
                });

                this.showToast('info', 'Saving task sequence...');

                fetch('/api/todo-tasks/bulk-save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    body: JSON.stringify({ tasks: this.configModalTasks })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.showToast('success', 'Task sequence updated successfully');
                        this.showConfigModal = false;
                        this.loadTasks();
                    } else {
                        this.showToast('error', data.message || 'Failed to save task sequence');
                    }
                })
                .catch(err => {
                    console.error('Sequence save error:', err);
                    this.showToast('error', 'Error updating task sequence');
                });
            },

            showToast(type, message) {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = `toast ${type}`;
                toast.innerHTML = `
                    <i class="fa ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle'}"></i>
                    <span>${message}</span>
                `;
                container.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.transition = 'all 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        };
    }
    </script>
</x-layout>
