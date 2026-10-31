<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userName = $_SESSION["user_name"] ?? "User";
$userEmail = $_SESSION["user_email"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TaskFlow - Task Manager</title>

    <link rel="stylesheet" href="p1.css">
</head>

<body>

<div class="app">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">

        <div class="logo">
            <div class="logo-icon">✓</div>
            <div>
                <h2>TaskFlow</h2>
                <span>Task Manager</span>
            </div>
        </div>

        <nav>

            <a href="index.php" class="nav-item active">
                <span>🏠</span>
                <span>Dashboard</span>
            </a>

            <a href="index.php#tasks" class="nav-item">
                <span>📋</span>
                <span>My Tasks</span>
            </a>

            <a href="index.php#add-task" class="nav-item">
                <span>➕</span>
                <span>Add Task</span>
            </a>

            <a href="index.php#statistics" class="nav-item">
                <span>📊</span>
                <span>Statistics</span>
            </a>

        </nav>

        <div class="sidebar-bottom">

            <button
                type="button"
                class="sidebar-button"
                id="themeToggle"
            >
                <span>🌙</span>
                <span>Dark Mode</span>
            </button>

            <a href="logout.php" class="nav-item">
                <span>🚪</span>
                <span>Logout</span>
            </a>

        </div>

    </aside>


    <!-- Main Content -->
    <main class="main">

        <!-- Top Header -->
        <header class="header">

            <button
                type="button"
                id="mobileMenu"
                class="mobile-menu"
                onclick="toggleMobileMenu()"
            >
                ☰
            </button>

            <div>
                <h1>Dashboard</h1>
                <p>Manage your tasks and stay productive.</p>
            </div>

            <div class="header-right">

                <div class="date" id="currentDate"></div>

                <div class="avatar">
                    <?= htmlspecialchars(strtoupper(substr($userName, 0, 1))) ?>
                </div>

            </div>

        </header>


        <!-- Welcome -->
        <section class="welcome-section">

            <div>
                <h2>Welcome back, <?= htmlspecialchars($userName) ?> 👋</h2>
                <p>Here is what's happening with your tasks today.</p>
            </div>

            <a href="#add-task" class="primary-button">
                + Add New Task
            </a>

        </section>


        <!-- Statistics -->
        <section class="stats" id="statistics">

            <div class="stat-card">

                <div class="stat-icon blue">📋</div>

                <div>
                    <p>Total Tasks</p>
                    <h2 id="totalTasks">0</h2>
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon green">✓</div>

                <div>
                    <p>Completed</p>
                    <h2 id="completedTasks">0</h2>
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon orange">⏳</div>

                <div>
                    <p>Pending</p>
                    <h2 id="pendingTasks">0</h2>
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon purple">📈</div>

                <div>
                    <p>Progress</p>
                    <h2 id="progressPercent">0%</h2>
                </div>

            </div>

        </section>


        <!-- Progress -->
        <section class="card progress-card">

            <div class="card-header">

                <div>
                    <h2>Overall Progress</h2>
                    <p>Keep going, you're doing great!</p>
                </div>

                <strong id="progressText">0%</strong>

            </div>

            <div class="progress-circle" id="progressCircle">

                <div class="progress-inner">

                    <strong id="progressCircleText">0%</strong>

                    <span>Completed</span>

                </div>

            </div>

            <div class="progress-info">

                <div>
                    <span class="dot completed-dot"></span>
                    <span>Completed</span>
                    <strong id="completedProgress">0</strong>
                </div>

                <div>
                    <span class="dot pending-dot"></span>
                    <span>Pending</span>
                    <strong id="pendingProgress">0</strong>
                </div>

            </div>

        </section>


        <!-- Add Task -->
        <section class="card" id="add-task">

            <div class="card-header">

                <div>
                    <h2>Add New Task</h2>
                    <p>Create a new task and keep your work organized.</p>
                </div>

            </div>


            <form
                id="taskForm"
                name="taskForm"
                method="POST"
                action="backend/create_task.php"
            >

                <div class="form-group">

                    <label for="taskTitle">Task Title</label>

                    <input
                        type="text"
                        id="taskTitle"
                        name="title"
                        placeholder="Enter task title"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="taskDescription">Description</label>

                    <textarea
                        id="taskDescription"
                        name="description"
                        placeholder="Enter task description"
                        rows="4"
                    ></textarea>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="taskPriority">Priority</label>

                        <select
                            id="taskPriority"
                            name="priority"
                            required
                        >
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>

                    </div>


                    <div class="form-group">

                        <label for="taskDate">Due Date</label>

                        <input
                            type="date"
                            id="taskDate"
                            name="due_date"
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="primary-button"
                >
                    + Add Task
                </button>

            </form>

        </section>


        <!-- Tasks -->
        <section class="card tasks-card" id="tasks">

            <div class="card-header">

                <div>
                    <h2>My Tasks</h2>
                    <p>View and manage all your tasks.</p>
                </div>


                <div class="task-controls">

                    <input
                        type="search"
                        id="searchTask"
                        placeholder="Search tasks..."
                    >

                    <select id="filterPriority">

                        <option value="all">
                            All Priorities
                        </option>

                        <option value="high">
                            High
                        </option>

                        <option value="medium">
                            Medium
                        </option>

                        <option value="low">
                            Low
                        </option>

                    </select>


                    <select id="filterStatus">

                        <option value="all">
                            All Status
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                    </select>

                </div>

            </div>


            <div id="taskList" class="task-list">

                <div class="loading">
                    Loading tasks...
                </div>

            </div>


            <div id="emptyState" class="empty-state">

                <div class="empty-icon">
                    ✓
                </div>

                <h3>No Tasks Found</h3>

                <p>
                    You don't have any tasks matching your current filters.
                </p>

            </div>

        </section>

    </main>

</div>


<!-- Edit Task Modal -->

<div class="modal-overlay hidden" id="editModal">

    <div class="modal">

        <div class="modal-header">

            <div>
                <h2>Edit Task</h2>
                <p>Update your task information.</p>
            </div>

            <button
                type="button"
                id="closeModal"
            >
                ×
            </button>

        </div>


        <form
            id="editForm"
            name="editTaskForm"
            method="POST"
            action="backend/update_task.php"
        >

            <input
                type="hidden"
                id="editTaskId"
                name="id"
            >


            <div class="form-group">

                <label for="editTitle">
                    Task Title
                </label>

                <input
                    type="text"
                    id="editTitle"
                    name="title"
                    required
                >

            </div>


            <div class="form-group">

                <label for="editDescription">
                    Description
                </label>

                <textarea
                    id="editDescription"
                    name="description"
                    rows="4"
                ></textarea>

            </div>


            <div class="form-row">

                <div class="form-group">

                    <label for="editPriority">
                        Priority
                    </label>

                    <select
                        id="editPriority"
                        name="priority"
                        required
                    >

                        <option value="low">
                            Low
                        </option>

                        <option value="medium">
                            Medium
                        </option>

                        <option value="high">
                            High
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="editDate">
                        Due Date
                    </label>

                    <input
                        type="date"
                        id="editDate"
                        name="due_date"
                    >

                </div>

            </div>


            <div class="form-group">

                <label for="editCompleted">
                    Status
                </label>

                <select
                    id="editCompleted"
                    name="completed"
                >

                    <option value="0">
                        Pending
                    </option>

                    <option value="1">
                        Completed
                    </option>

                </select>

            </div>


            <div class="modal-actions">

                <button
                    type="button"
                    id="cancelEdit"
                    class="secondary-button"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="primary-button"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


<script src="p1.js"></script>

</body>
</html>