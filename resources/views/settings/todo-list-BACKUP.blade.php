<x-layout>
    @push('styles')
    <x-list-styles />
    <style>
        [x-cloak] { display: none !important; }
        
        /* EXACT PROJECT PORTLET STYLING */
        .portlet.light.portlet-list-view {
            background: #fff;
            border: 1px solid #e7ecf1;
            margin-bottom: 10px;
        }
        
        .portlet-title {
            padding: 15px 20px;
            border-bottom: 1px solid #eef1f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .caption-subject.font-blue-steel {
            font-size: 16px;
            font-weight: 600;
            color: #32c5d2;
        }
        
        /* PORTLET TOOL - EXACT PROJECT STYLING */
        .portlet-tool {
            padding: 10px 20px;
            background: #fafafa;
            border-bottom: 1px solid #eef1f5;
        }
        
        .pull-left._mg-bottom-10 {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        /* BUTTON GROUP - EXACT PROJECT STYLING */
        .btn-group {
            display: inline-flex;
            box-shadow: none;
        }
        
        .btn-group .btn {
            margin: 0;
            border-radius: 0;
            border-right: 1px solid #ddd;
        }
        
        .btn-group .btn:first-child {
            border-radius: 4px 0 0 4px;
        }
        
        .btn-group .btn:last-child {
            border-radius: 0 4px 4px 0;
            border-right: none;
        }
        
        .btn.btn-default {
            background: #fff;
            border: 1px solid #e7ecf1;
            color: #666;
            padding: 6px 12px;
            font-size: 12px;
            height: 32px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn.btn-default:hover {
            background: #f5f5f5;
        }
        
        .btn.btn-default.active {
            background: #32c5d2;
            color: #fff;
            border-color: #32c5d2;
        }
        
        .btn.green {
            background: #32c5d2;
            color: #fff;
            border: none;
            padding: 6px 12px;
            font-size: 14px;
            height: 32px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn.green:hover {
            background: #27a9b5;
        }
        
        .btn.blue-hoki {
            background: #67809f;
            color: #fff;
            border: none;
            padding: 6px 12px;
            font-size: 12px;
            height: 32px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn.blue-hoki:hover {
            background: #597089;
        }
        
        .actions.pull-right {
            float: right;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        /* TWO-COLUMN LAYOUT - EXACT PROJECT STYLING */
        .row {
            display: flex;
            margin: 0 -15px;
        }
        
        .col-xs-7 {
            width: 58.33333333%;
            padding: 0 15px;
        }
        
        .col-xs-5 {
            width: 41.66666667%;
            padding: 0 15px;
        }
        
        /* TASK LIST - EXACT PROJECT STYLING */
        .to-do-setting-list {
            padding: 15px;
            max-height: calc(100vh - 300px);
            overflow-y: auto;
        }
        
        .to-do-setting {
            background: #fff;
            border: 1px solid #e7ecf1;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .to-do-setting:hover {
            border-color: #32c5d2;
            box-shadow: 0 2px 4px rgba(50, 197, 210, 0.1);
        }
        
        .to-do-setting.active {
            background: #f0f9ff;
            border-color: #32c5d2;
        }
        
        ._flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        ._flex-1 {
            flex: 1;
            min-width: 0;
        }
        
        ._font-14 {
            font-size: 14px;
        }
        
        ._font-15 {
            font-size: 15px;
        }
        
        ._font-12 {
            font-size: 12px;
        }
        
        .bold {
            font-weight: 600;
        }
        
        .text-hidden {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .text-muted {
            color: #999;
        }
        
        ._mg-right-10 {
            margin-right: 10px;
        }
        
        .mg-left-xs {
            margin-left: 5px;
        }

        .task-item:hover .task-item-actions {
            opacity: 1;
        }

        .task-item-icon {
            width: 22px;
            height: 22px;
            border-radius: 3px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            transition: all 0.2s;
        }

        .task-item-icon:hover {
            background: #f8fafc;
            border-color: #4b77be;
            color: #4b77be;
        }

        .task-item-icon.delete:hover {
            background: #fef2f2;
            border-color: #ef4444;
            color: #ef4444;
        }

        /* RIGHT COLUMN - Workflow Config */
        .workflow-config-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .workflow-config-header {
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #fff;
        }

        .workflow-config-title {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .workflow-config-subtitle {
            font-size: 9px;
            color: #64748b;
        }

        .workflow-config-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .workflow-config-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #94a3b8;
            text-align: center;
        }

        .workflow-config-empty i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.4;
        }

        .workflow-config-empty p {
            font-size: 11px;
            margin: 0;
        }

        /* WORKFLOW SECTIONS */
        .workflow-section {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .workflow-section-title {
            font-size: 10px;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .workflow-section-title i {
            color: #4b77be;
            font-size: 11px;
        }

        /* FORM ELEMENTS */
        .workflow-form-group {
            margin-bottom: 14px;
        }

        .workflow-form-group:last-child {
            margin-bottom: 0;
        }

        .workflow-label {
            font-size: 9px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .workflow-input,
        .workflow-select,
        .workflow-textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 7px 10px;
            font-size: 10px;
            color: #1e293b;
            background: #fff;
            transition: all 0.2s;
        }

        .workflow-input:focus,
        .workflow-select:focus,
        .workflow-textarea:focus {
            outline: none;
            border-color: #4b77be;
            box-shadow: 0 0 0 3px rgba(75, 119, 190, 0.1);
        }

        .workflow-textarea {
            resize: vertical;
            min-height: 60px;
        }

        /* CONDITION BUILDER */
        .condition-group {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 10px;
        }

        .condition-row {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 8px;
        }

        .condition-row:last-child {
            margin-bottom: 0;
        }

        .condition-select {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            padding: 5px 8px;
            font-size: 9px;
            background: #fff;
        }

        .condition-input {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            padding: 5px 8px;
            font-size: 9px;
            background: #fff;
        }

        .condition-btn {
            width: 24px;
            height: 24px;
            border-radius: 3px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            transition: all 0.2s;
        }

        .condition-btn:hover {
            background: #fef2f2;
            border-color: #ef4444;
            color: #ef4444;
        }

        .condition-btn.add {
            width: auto;
            padding: 0 10px;
            font-size: 9px;
            font-weight: 600;
        }

        .condition-btn.add:hover {
            background: #f0fdf4;
            border-color: #22c55e;
            color: #22c55e;
        }

        .condition-operator {
            display: flex;
            gap: 4px;
            margin: 8px 0;
        }

        .operator-btn {
            padding: 4px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            background: #fff;
            color: #64748b;
            font-size: 9px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .operator-btn:hover {
            border-color: #4b77be;
            color: #4b77be;
        }

        .operator-btn.active {
            background: #4b77be;
            border-color: #4b77be;
            color: #fff;
        }

        /* ACTION BUTTONS */
        .workflow-actions {
            display: flex;
            gap: 8px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }

        .workflow-btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .workflow-btn:hover {
            border-color: #4b77be;
            color: #4b77be;
            background: #f0f9ff;
        }

        .workflow-btn.primary {
            background: #4b77be;
            border-color: #4b77be;
            color: #fff;
        }

        .workflow-btn.primary:hover {
            background: #3d6396;
            border-color: #3d6396;
        }

        .workflow-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* CHECKBOX STYLE */
        .workflow-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 9px;
            color: #475569;
            margin-bottom: 8px;
        }

        .workflow-checkbox input[type="checkbox"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
        }

        /* ADD TASK BUTTON */
        .add-task-btn {
            width: 100%;
            padding: 8px;
            border: 1px dashed #cbd5e1;
            border-radius: 4px;
            background: #fff;
            color: #64748b;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .add-task-btn:hover {
            border-color: #4b77be;
            color: #4b77be;
            background: #f0f9ff;
        }
    </style>
    @endpush

    {{-- ═══════ TOAST CONTAINER ═══════ --}}
    <div class="toast-container" id="toast-container"></div>

    {{-- ═══════ MAIN PAGE ═══════ --}}
    <div class="page-content">

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><i class="fa fa-home"></i> <a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
                <li>Settings <i class="fa fa-angle-right"></i></li>
                <li><span style="color:#333;font-weight:700;">To Do List</span></li>
            </ul>
        </div>

        <div class="portlet light" x-data="todoListApp()">

            {{-- ── PORTLET TITLE ── --}}
            <div class="portlet-title">
                <div class="caption" style="display:flex;align-items:center;gap:12px;">
                    <i class="fa fa-check-square-o" style="font-size:18px;color:#4b77be;"></i>
                    <span class="caption-subject">TO DO LIST SETTINGS</span>
                </div>
                <div class="actions" style="display:flex;gap:4px;position:relative;align-items:center;">
                    <button class="btn-action-round white" @click="printList()" title="Print this page">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
            </div>

            {{-- ── MODULE TABS ── --}}
            <div class="todo-tabs">
                <button class="todo-tab" 
                        :class="{'active': activeTab === 'ocean-import'}"
                        @click="switchTab('ocean-import')">
                    <i class="fa fa-ship"></i> Ocean Import
                </button>
                <button class="todo-tab" 
                        :class="{'active': activeTab === 'ocean-export'}"
                        @click="switchTab('ocean-export')">
                    <i class="fa fa-anchor"></i> Ocean Export
                </button>
                <button class="todo-tab" 
                        :class="{'active': activeTab === 'air-import'}"
                        @click="switchTab('air-import')">
                    <i class="fa fa-plane"></i> Air Import
                </button>
                <button class="todo-tab" 
                        :class="{'active': activeTab === 'air-export'}"
                        @click="switchTab('air-export')">
                    <i class="fa fa-plane"></i> Air Export
                </button>
                <button class="todo-tab" 
                        :class="{'active': activeTab === 'trucking'}"
                        @click="switchTab('trucking')">
                    <i class="fa fa-truck"></i> Trucking
                </button>
            </div>

            {{-- ── TWO-COLUMN WORKFLOW LAYOUT ── --}}
            <div class="workflow-container">
                
                {{-- LEFT COLUMN: Task List --}}
                <div class="task-list-column">
                    <div class="task-list-header">
                        <h3>Task Items</h3>
                        <span style="font-size:9px;color:#64748b;">
                            <span x-text="filteredTasks.length"></span> items
                        </span>
                    </div>
                    
                    <div class="task-list-body">
                        {{-- Task Items --}}
                        <template x-for="(task, index) in filteredTasks" :key="task.id || index">
                            <div class="task-item" 
                                 :class="{'active': selectedTask && selectedTask.id === task.id}"
                                 @click="selectTask(task)">
                                <div class="task-item-content">
                                    <div class="task-item-title" x-text="task.title || 'Untitled Task'"></div>
                                    <div class="task-item-desc" x-text="task.description || 'No description'"></div>
                                </div>
                                <div class="task-item-actions">
                                    <div class="task-item-icon" @click.stop="duplicateTask(task)" title="Duplicate">
                                        <i class="fa fa-copy"></i>
                                    </div>
                                    <div class="task-item-icon delete" @click.stop="deleteSingleTask(task)" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- Add Task Button --}}
                        <button class="add-task-btn" @click="addTask()">
                            <i class="fa fa-plus"></i>
                            <span>Add New Task</span>
                        </button>

                        {{-- Empty State --}}
                        <template x-if="filteredTasks.length === 0">
                            <div style="text-align:center;padding:40px 20px;color:#94a3b8;">
                                <i class="fa fa-inbox" style="font-size:36px;display:block;margin-bottom:12px;opacity:0.4;"></i>
                                <p style="font-size:10px;margin:0;">No tasks yet. Click "Add New Task" to start.</p>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Workflow Configuration --}}
                <div class="workflow-config-column">
                    {{-- Config Header --}}
                    <div class="workflow-config-header">
                        <div class="workflow-config-title" x-text="selectedTask ? selectedTask.title || 'Untitled Task' : 'Workflow Configuration'"></div>
                        <div class="workflow-config-subtitle">Configure automation rules and notifications</div>
                    </div>

                    {{-- Config Body --}}
                    <div class="workflow-config-body">
                        {{-- No Task Selected --}}
                        <template x-if="!selectedTask">
                            <div class="workflow-config-empty">
                                <i class="fa fa-hand-pointer-o"></i>
                                <p>Select a task from the left to configure its workflow</p>
                            </div>
                        </template>

                        {{-- Task Selected - Show Config --}}
                        <template x-if="selectedTask">
                            <div>
                                {{-- BASIC INFO SECTION --}}
                                <div class="workflow-section">
                                    <div class="workflow-section-title">
                                        <i class="fa fa-info-circle"></i>
                                        <span>Basic Information</span>
                                    </div>
                                    
                                    <div class="workflow-form-group">
                                        <label class="workflow-label">Task Title</label>
                                        <input type="text" 
                                               x-model="selectedTask.title" 
                                               @input="selectedTask._unsaved = true"
                                               class="workflow-input" 
                                               placeholder="Enter task title...">
                                    </div>

                                    <div class="workflow-form-group">
                                        <label class="workflow-label">Description</label>
                                        <textarea x-model="selectedTask.description" 
                                                  @input="selectedTask._unsaved = true"
                                                  class="workflow-textarea" 
                                                  placeholder="Describe this task..."></textarea>
                                    </div>
                                </div>

                                {{-- WHEN TO START SECTION --}}
                                <div class="workflow-section">
                                    <div class="workflow-section-title">
                                        <i class="fa fa-clock-o"></i>
                                        <span>When to Start</span>
                                    </div>

                                    <div class="workflow-form-group">
                                        <label class="workflow-label">Start Time</label>
                                        <select x-model="selectedTask.config.startTime" 
                                                @change="selectedTask._unsaved = true"
                                                class="workflow-select">
                                            <option value="">Select when to start...</option>
                                            <option value="immediately">Immediately</option>
                                            <option value="after_1_hour">After 1 Hour</option>
                                            <option value="after_2_hours">After 2 Hours</option>
                                            <option value="after_4_hours">After 4 Hours</option>
                                            <option value="after_1_day">After 1 Day</option>
                                            <option value="after_2_days">After 2 Days</option>
                                            <option value="after_3_days">After 3 Days</option>
                                            <option value="after_1_week">After 1 Week</option>
                                        </select>
                                    </div>

                                    <div class="workflow-form-group">
                                        <label class="workflow-label">Relative To</label>
                                        <select x-model="selectedTask.config.relativeTo" 
                                                @change="selectedTask._unsaved = true"
                                                class="workflow-select">
                                            <option value="">Select reference point...</option>
                                            <option value="etd">ETD (Estimated Time of Departure)</option>
                                            <option value="eta">ETA (Estimated Time of Arrival)</option>
                                            <option value="post_date">Post Date</option>
                                            <option value="created_date">Shipment Created Date</option>
                                            <option value="booking_date">Booking Date</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- CONDITION SECTION --}}
                                <div class="workflow-section">
                                    <div class="workflow-section-title">
                                        <i class="fa fa-filter"></i>
                                        <span>Conditions</span>
                                    </div>

                                    <div class="workflow-form-group">
                                        <label class="workflow-label">Apply When</label>
                                        
                                        {{-- Condition Groups --}}
                                        <template x-for="(group, groupIdx) in selectedTask.config.conditions" :key="groupIdx">
                                            <div class="condition-group">
                                                {{-- Condition Rows --}}
                                                <template x-for="(condition, condIdx) in group" :key="condIdx">
                                                    <div class="condition-row">
                                                        <select x-model="condition.field" class="condition-select">
                                                            <option value="">Field...</option>
                                                            <option value="customer">Customer</option>
                                                            <option value="carrier">Carrier</option>
                                                            <option value="pol">Port of Loading</option>
                                                            <option value="pod">Port of Discharge</option>
                                                            <option value="freight_term">Freight Term</option>
                                                            <option value="bl_type">B/L Type</option>
                                                            <option value="container_type">Container Type</option>
                                                        </select>
                                                        
                                                        <select x-model="condition.operator" class="condition-select" style="flex:0.5;">
                                                            <option value="equals">Equals</option>
                                                            <option value="not_equals">Not Equals</option>
                                                            <option value="contains">Contains</option>
                                                            <option value="not_contains">Not Contains</option>
                                                        </select>
                                                        
                                                        <input type="text" 
                                                               x-model="condition.value" 
                                                               class="condition-input" 
                                                               placeholder="Value...">
                                                        
                                                        <button class="condition-btn" 
                                                                @click="removeCondition(groupIdx, condIdx)" 
                                                                title="Remove">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </template>

                                                {{-- Add Condition Button --}}
                                                <button class="condition-btn add" @click="addCondition(groupIdx)">
                                                    <i class="fa fa-plus"></i> AND Condition
                                                </button>
                                            </div>
                                        </template>

                                        {{-- Operator Buttons --}}
                                        <div class="condition-operator">
                                            <button class="operator-btn" @click="addConditionGroup()">
                                                <i class="fa fa-plus"></i> OR Group
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- ACTION SECTION --}}
                                <div class="workflow-section">
                                    <div class="workflow-section-title">
                                        <i class="fa fa-bolt"></i>
                                        <span>Actions</span>
                                    </div>

                                    <div class="workflow-form-group">
                                        <label class="workflow-label">Action Type</label>
                                        <select x-model="selectedTask.config.actionType" 
                                                @change="selectedTask._unsaved = true"
                                                class="workflow-select">
                                            <option value="">Select action...</option>
                                            <option value="email">Send Email</option>
                                            <option value="notification">System Notification</option>
                                            <option value="update_status">Update Status</option>
                                            <option value="assign_task">Assign Task</option>
                                        </select>
                                    </div>

                                    <template x-if="selectedTask.config.actionType === 'email'">
                                        <div>
                                            <div class="workflow-form-group">
                                                <label class="workflow-label">Email Recipients</label>
                                                <input type="text" 
                                                       x-model="selectedTask.config.emailTo" 
                                                       @input="selectedTask._unsaved = true"
                                                       class="workflow-input" 
                                                       placeholder="email@example.com, email2@example.com">
                                            </div>

                                            <div class="workflow-form-group">
                                                <label class="workflow-label">Email Subject</label>
                                                <input type="text" 
                                                       x-model="selectedTask.config.emailSubject" 
                                                       @input="selectedTask._unsaved = true"
                                                       class="workflow-input" 
                                                       placeholder="Email subject...">
                                            </div>

                                            <div class="workflow-form-group">
                                                <label class="workflow-label">Email Body</label>
                                                <textarea x-model="selectedTask.config.emailBody" 
                                                          @input="selectedTask._unsaved = true"
                                                          class="workflow-textarea" 
                                                          placeholder="Email message..."></textarea>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="selectedTask.config.actionType === 'notification'">
                                        <div class="workflow-form-group">
                                            <label class="workflow-label">Notification Message</label>
                                            <textarea x-model="selectedTask.config.notificationMessage" 
                                                      @input="selectedTask._unsaved = true"
                                                      class="workflow-textarea" 
                                                      placeholder="Notification message..."></textarea>
                                        </div>
                                    </template>

                                    <template x-if="selectedTask.config.actionType === 'assign_task'">
                                        <div class="workflow-form-group">
                                            <label class="workflow-label">Assign To</label>
                                            <select x-model="selectedTask.config.assignTo" 
                                                    @change="selectedTask._unsaved = true"
                                                    class="workflow-select">
                                                <option value="">Select user...</option>
                                                <option value="operator">Shipment Operator</option>
                                                <option value="sales">Sales Person</option>
                                                <option value="manager">Manager</option>
                                            </select>
                                        </div>
                                    </template>

                                    <div class="workflow-checkbox">
                                        <input type="checkbox" 
                                               x-model="selectedTask.config.isActive" 
                                               @change="selectedTask._unsaved = true">
                                        <label>Active (workflow will execute)</label>
                                    </div>
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="workflow-actions">
                                    <button class="workflow-btn primary" 
                                            @click="saveTask(selectedTask)"
                                            :disabled="!selectedTask._unsaved">
                                        <i class="fa fa-save"></i> Save Workflow
                                    </button>
                                    <button class="workflow-btn" 
                                            @click="cancelTaskChanges()"
                                            :disabled="!selectedTask._unsaved">
                                        <i class="fa fa-undo"></i> Discard Changes
                                    </button>
                                    <button class="workflow-btn" 
                                            @click="testWorkflow()"
                                            style="margin-left:auto;">
                                        <i class="fa fa-play"></i> Test Workflow
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    function todoListApp() {
        return {
            activeTab: 'ocean-import',
            tasks: @json($tasks ?? []),
            filteredTasks: [],
            selectedTask: null,

            init() {
                this.loadTasks();
            },

            switchTab(tab) {
                if (this.selectedTask && this.selectedTask._unsaved) {
                    if (!confirm('You have unsaved changes. Do you want to discard them?')) {
                        return;
                    }
                }
                this.activeTab = tab;
                this.selectedTask = null;
                this.loadTasks();
            },

            async loadTasks() {
                try {
                    const response = await fetch(`/api/todo-tasks?module=${this.activeTab}`);
                    if (response.ok) {
                        const data = await response.json();
                        this.tasks = (data.tasks || []).map(t => this.initializeTaskConfig(t));
                        this.filterTasks();
                    }
                } catch (error) {
                    console.error('Failed to load tasks:', error);
                    showToast('error', 'Failed to load tasks');
                }
            },

            initializeTaskConfig(task) {
                if (!task.config) {
                    task.config = {
                        startTime: '',
                        relativeTo: '',
                        conditions: [[{ field: '', operator: 'equals', value: '' }]],
                        actionType: '',
                        emailTo: '',
                        emailSubject: '',
                        emailBody: '',
                        notificationMessage: '',
                        assignTo: '',
                        isActive: true
                    };
                }
                if (!task.config.conditions || task.config.conditions.length === 0) {
                    task.config.conditions = [[{ field: '', operator: 'equals', value: '' }]];
                }
                task._unsaved = false;
                return task;
            },

            filterTasks() {
                this.filteredTasks = this.tasks.filter(t => t.module === this.activeTab);
                // Auto-select first task if none selected
                if (this.filteredTasks.length > 0 && !this.selectedTask) {
                    this.selectedTask = this.filteredTasks[0];
                }
            },

            selectTask(task) {
                if (this.selectedTask && this.selectedTask._unsaved) {
                    if (!confirm('You have unsaved changes. Do you want to discard them?')) {
                        return;
                    }
                }
                this.selectedTask = task;
            },

            addTask() {
                const newTask = {
                    id: null,
                    module: this.activeTab,
                    title: 'New Task',
                    description: '',
                    order: this.tasks.length + 1,
                    is_active: true,
                    _unsaved: true,
                    config: {
                        startTime: '',
                        relativeTo: '',
                        conditions: [[{ field: '', operator: 'equals', value: '' }]],
                        actionType: '',
                        emailTo: '',
                        emailSubject: '',
                        emailBody: '',
                        notificationMessage: '',
                        assignTo: '',
                        isActive: true
                    }
                };
                this.tasks.unshift(newTask);
                this.filterTasks();
                this.selectedTask = newTask;
                showToast('info', 'New task added. Configure and save!');
            },

            duplicateTask(task) {
                const duplicate = JSON.parse(JSON.stringify(task));
                duplicate.id = null;
                duplicate.title = task.title + ' (Copy)';
                duplicate._unsaved = true;
                this.tasks.push(duplicate);
                this.filterTasks();
                this.selectedTask = duplicate;
                showToast('info', 'Task duplicated. Don\'t forget to save!');
            },

            addCondition(groupIdx) {
                this.selectedTask.config.conditions[groupIdx].push({
                    field: '',
                    operator: 'equals',
                    value: ''
                });
                this.selectedTask._unsaved = true;
            },

            removeCondition(groupIdx, condIdx) {
                if (this.selectedTask.config.conditions[groupIdx].length === 1) {
                    showToast('error', 'Cannot remove the last condition in a group');
                    return;
                }
                this.selectedTask.config.conditions[groupIdx].splice(condIdx, 1);
                this.selectedTask._unsaved = true;
            },

            addConditionGroup() {
                this.selectedTask.config.conditions.push([{
                    field: '',
                    operator: 'equals',
                    value: ''
                }]);
                this.selectedTask._unsaved = true;
            },

            async saveTask(task) {
                if (!task.title.trim()) {
                    showToast('error', 'Task title is required');
                    return;
                }

                showToast('info', 'Saving workflow...');

                try {
                    const url = task.id ? `/api/todo-tasks/${task.id}` : '/api/todo-tasks';
                    const method = task.id ? 'PUT' : 'POST';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            module: task.module,
                            title: task.title,
                            description: task.description,
                            order: task.order,
                            is_active: task.is_active,
                            config: task.config
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        if (!task.id) {
                            task.id = data.task.id;
                        }
                        task._unsaved = false;
                        showToast('success', 'Workflow saved successfully');
                    } else {
                        showToast('error', data.message || 'Failed to save');
                    }
                } catch (error) {
                    console.error('Save error:', error);
                    showToast('error', 'Failed to save workflow');
                }
            },

            async deleteSingleTask(task) {
                if (!confirm('Delete this task and its workflow?')) return;

                if (!task.id) {
                    this.tasks = this.tasks.filter(t => t !== task);
                    this.filterTasks();
                    if (this.selectedTask === task) {
                        this.selectedTask = this.filteredTasks[0] || null;
                    }
                    showToast('success', 'Task removed');
                    return;
                }

                showToast('info', 'Deleting...');

                try {
                    const response = await fetch(`/api/todo-tasks/${task.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.tasks = this.tasks.filter(t => t.id !== task.id);
                        this.filterTasks();
                        if (this.selectedTask === task) {
                            this.selectedTask = this.filteredTasks[0] || null;
                        }
                        showToast('success', 'Task deleted');
                    } else {
                        showToast('error', data.message || 'Failed to delete');
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    showToast('error', 'Failed to delete task');
                }
            },

            cancelTaskChanges() {
                if (!confirm('Discard all unsaved changes?')) return;
                this.loadTasks();
                showToast('info', 'Changes discarded');
            },

            testWorkflow() {
                if (this.selectedTask._unsaved) {
                    showToast('error', 'Please save the workflow before testing');
                    return;
                }
                showToast('info', 'Testing workflow... (This is a demo)');
                
                setTimeout(() => {
                    showToast('success', 'Workflow test completed successfully!');
                }, 1500);
            },

            printList() {
                const url = `/settings/todo-list-print?module=${this.activeTab}`;
                showToast('info', 'Opening print view...');
                window.open(url, '_blank');
            }
        }
    }

    function showToast(type, msg) {
        const icons = { success: 'check-circle', error: 'times-circle', info: 'info-circle' };
        const t = document.createElement('div');
        t.className = `toast ${type}`;
        t.innerHTML = `<i class="fa fa-${icons[type] || 'info-circle'}"></i> <span>${msg}</span>`;
        const container = document.getElementById('toast-container');
        if (container) {
            container.appendChild(t);
            setTimeout(() => {
                if (t.parentElement) {
                    t.style.opacity = '0';
                    t.style.transform = 'translateX(100%)';
                    setTimeout(() => t.remove(), 300);
                }
            }, 3000);
        }
    }

    @if(session('success'))
        showToast('success', @json(session('success')));
    @endif
    @if(session('error'))
        showToast('error', @json(session('error')));
    @endif
    </script>
    @endpush
</x-layout>
