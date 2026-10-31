/* =====================================================
   TASKFLOW - FRONTEND JAVASCRIPT
   Currently using localStorage.
   Later replace this with PHP/MySQL API calls.
===================================================== */


// ===============================
// DATA
// ===============================

let tasks = JSON.parse(localStorage.getItem("tasks")) || [];


// ===============================
// DOM ELEMENTS
// ===============================

const taskForm = document.getElementById("taskForm");

const taskTitle = document.getElementById("taskTitle");
const taskDescription = document.getElementById("taskDescription");
const taskPriority = document.getElementById("taskPriority");
const taskDate = document.getElementById("taskDate");

const taskList = document.getElementById("taskList");
const emptyState = document.getElementById("emptyState");

const searchInput = document.getElementById("searchTask");
const filterPriority = document.getElementById("filterPriority");

const editModal = document.getElementById("editModal");
const editForm = document.getElementById("editForm");

const editTaskId = document.getElementById("editTaskId");
const editTitle = document.getElementById("editTitle");
const editDescription = document.getElementById("editDescription");
const editPriority = document.getElementById("editPriority");
const editDate = document.getElementById("editDate");


// ===============================
// SAVE DATA
// ===============================

function saveTasks() {

    localStorage.setItem(
        "tasks",
        JSON.stringify(tasks)
    );

}


// ===============================
// ADD TASK
// ===============================

taskForm.addEventListener("submit", function(event) {

    event.preventDefault();

    const title = taskTitle.value.trim();

    if (!title) {
        alert("Please enter a task title.");
        return;
    }

    const newTask = {

        id: Date.now(),

        title: title,

        description: taskDescription.value.trim(),

        priority: taskPriority.value,

        dueDate: taskDate.value,

        completed: false,

        createdAt: new Date().toISOString()

    };

    tasks.unshift(newTask);

    saveTasks();

    taskForm.reset();

    renderAll();

    alert("Task added successfully!");

});


// ===============================
// CREATE TASK HTML
// ===============================

function createTaskHTML(task) {

    const dateText = task.dueDate
        ? formatDate(task.dueDate)
        : "No due date";

    return `

        <div class="task ${task.completed ? "completed" : ""}">

            <input
                type="checkbox"
                class="task-checkbox"
                ${task.completed ? "checked" : ""}
                onchange="toggleTask(${task.id})"
            >

            <div class="task-info">

                <div class="task-title">
                    ${escapeHTML(task.title)}
                </div>

                ${
                    task.description
                    ? `<div class="task-description">
                        ${escapeHTML(task.description)}
                       </div>`
                    : ""
                }

                <div class="task-date">
                    Due: ${dateText}
                </div>

            </div>

            <div class="task-actions">

                <span class="priority priority-${task.priority}">
                    ${task.priority}
                </span>

                <button
                    class="action-button"
                    onclick="openEditModal(${task.id})"
                    title="Edit"
                >
                    ✎
                </button>

                <button
                    class="action-button delete-button"
                    onclick="deleteTask(${task.id})"
                    title="Delete"
                >
                    🗑
                </button>

            </div>

        </div>

    `;

}


// ===============================
// RENDER DASHBOARD TASKS
// ===============================

function renderTasks() {

    const search = searchInput.value.toLowerCase().trim();

    const priority = filterPriority.value;

    let filteredTasks = tasks.filter(task => {

        const matchesSearch =
            task.title.toLowerCase().includes(search) ||
            task.description.toLowerCase().includes(search);

        const matchesPriority =
            priority === "all" ||
            task.priority === priority;

        return matchesSearch && matchesPriority;

    });


    taskList.innerHTML = filteredTasks
        .map(task => createTaskHTML(task))
        .join("");


    if (filteredTasks.length === 0) {

        emptyState.style.display = "block";

    } else {

        emptyState.style.display = "none";

    }

}


// ===============================
// RENDER ALL TASKS
// ===============================

function renderAllTasks() {

    const container = document.getElementById("allTaskList");

    container.innerHTML = tasks.length

        ? tasks.map(task => createTaskHTML(task)).join("")

        : emptyHTML();

}


// ===============================
// RENDER PENDING
// ===============================

function renderPendingTasks() {

    const container = document.getElementById("pendingTaskList");

    const pending = tasks.filter(task => !task.completed);

    container.innerHTML = pending.length

        ? pending.map(task => createTaskHTML(task)).join("")

        : emptyHTML();

}


// ===============================
// RENDER COMPLETED
// ===============================

function renderCompletedTasks() {

    const container = document.getElementById("completedTaskList");

    const completed = tasks.filter(task => task.completed);

    container.innerHTML = completed.length

        ? completed.map(task => createTaskHTML(task)).join("")

        : emptyHTML();

}


// ===============================
// EMPTY HTML
// ===============================

function emptyHTML() {

    return `

        <div class="empty-state" style="display:block">

            <div class="empty-icon">✓</div>

            <h3>No tasks found</h3>

            <p>There are no tasks in this section.</p>

        </div>

    `;

}


// ===============================
// TOGGLE TASK
// ===============================

function toggleTask(id) {

    const task = tasks.find(task => task.id === id);

    if (!task) return;

    task.completed = !task.completed;

    saveTasks();

    renderAll();

}


// ===============================
// DELETE TASK
// ===============================

function deleteTask(id) {

    const confirmed = confirm(
        "Are you sure you want to delete this task?"
    );

    if (!confirmed) return;

    tasks = tasks.filter(task => task.id !== id);

    saveTasks();

    renderAll();

}


// ===============================
// EDIT MODAL
// ===============================

function openEditModal(id) {

    const task = tasks.find(task => task.id === id);

    if (!task) return;

    editTaskId.value = task.id;

    editTitle.value = task.title;

    editDescription.value = task.description;

    editPriority.value = task.priority;

    editDate.value = task.dueDate;

    editModal.classList.remove("hidden");

}


function closeEditModal() {

    editModal.classList.add("hidden");

}


document
    .getElementById("closeModal")
    .addEventListener("click", closeEditModal);


document
    .getElementById("cancelEdit")
    .addEventListener("click", closeEditModal);


// ===============================
// SAVE EDIT
// ===============================

editForm.addEventListener("submit", function(event) {

    event.preventDefault();

    const id = Number(editTaskId.value);

    const task = tasks.find(task => task.id === id);

    if (!task) return;

    task.title = editTitle.value.trim();

    task.description = editDescription.value.trim();

    task.priority = editPriority.value;

    task.dueDate = editDate.value;

    saveTasks();

    closeEditModal();

    renderAll();

});


// ===============================
// SEARCH
// ===============================

searchInput.addEventListener(
    "input",
    renderTasks
);


// ===============================
// FILTER
// ===============================

filterPriority.addEventListener(
    "change",
    renderTasks
);


// ===============================
// STATISTICS
// ===============================

function updateStats() {

    const total = tasks.length;

    const completed =
        tasks.filter(task => task.completed).length;

    const pending = total - completed;

    const percentage = total === 0
        ? 0
        : Math.round((completed / total) * 100);


    document.getElementById("totalTasks").textContent =
        total;

    document.getElementById("pendingTasks").textContent =
        pending;

    document.getElementById("completedTasks").textContent =
        completed;

    document.getElementById("progressPercent").textContent =
        percentage + "%";


    document.getElementById("progressCircleText").textContent =
        percentage + "%";


    document.getElementById("completedProgress").textContent =
        completed;


    document.getElementById("pendingProgress").textContent =
        pending;


    const degrees = percentage * 3.6;

    document.querySelector(".progress-circle").style.background =
        `conic-gradient(
            var(--primary) ${degrees}deg,
            #e5e7eb ${degrees}deg
        )`;

}


// ===============================
// RENDER EVERYTHING
// ===============================

function renderAll() {

    renderTasks();

    updateStats();

}


// ===============================
// NAVIGATION
// ===============================

const navItems =
    document.querySelectorAll(".nav-item");


navItems.forEach(item => {

    item.addEventListener("click", function(event) {

        event.preventDefault();

        navItems.forEach(nav =>
            nav.classList.remove("active")
        );

        this.classList.add("active");

        const section =
            this.dataset.section;

        showSection(section);

    });

});


function showSection(section) {

    const sections = {

        dashboard:
            document.getElementById("dashboardSection"),

        tasks:
            document.getElementById("tasksSection"),

        pending:
            document.getElementById("pendingSection"),

        completed:
            document.getElementById("completedSection")

    };


    Object.values(sections).forEach(sectionElement => {

        sectionElement.classList.add("hidden-section");

    });


    sections[section].classList.remove(
        "hidden-section"
    );


    const titles = {

        dashboard: [
            "Dashboard",
            "Manage your tasks efficiently."
        ],

        tasks: [
            "All Tasks",
            "View and manage all your tasks."
        ],

        pending: [
            "Pending Tasks",
            "Tasks that still need your attention."
        ],

        completed: [
            "Completed Tasks",
            "Tasks you have successfully completed."
        ]

    };


    document.getElementById("pageTitle").textContent =
        titles[section][0];

    document.getElementById("pageSubtitle").textContent =
        titles[section][1];

}


// ===============================
// DARK MODE
// ===============================

const darkModeBtn =
    document.getElementById("themeToggle");


darkModeBtn.addEventListener("click", function() {

    document.body.classList.toggle("dark");

    const dark =
        document.body.classList.contains("dark");

    localStorage.setItem(
        "darkMode",
        dark
    );

});


if (localStorage.getItem("darkMode") === "true") {

    document.body.classList.add("dark");

}


// ===============================
// CLEAR DATA
// ===============================

document
    .getElementById("clearDataBtn")
    .addEventListener("click", function() {

        if (tasks.length === 0) {

            alert("There is no data to clear.");

            return;

        }

        const confirmed = confirm(
            "This will delete ALL tasks. Continue?"
        );

        if (!confirmed) return;

        tasks = [];

        saveTasks();

        renderAll();

    });


// ===============================
// MOBILE MENU
// ===============================

function toggleMobileMenu() {

    const sidebar = document.getElementById("sidebar");
    const menuBtn = document.getElementById("mobileMenu");
    const main = document.querySelector(".main");

    if (!sidebar || !menuBtn || !main) {
        return;
    }

    if (window.innerWidth <= 768) {

        // MOBILE
        sidebar.classList.toggle("open");

        if (sidebar.classList.contains("open")) {
            menuBtn.innerHTML = "✕";
        } else {
            menuBtn.innerHTML = "☰";
        }

    } else {

        // LAPTOP / DESKTOP
        sidebar.classList.toggle("closed");
        main.classList.toggle("full-width");

        if (sidebar.classList.contains("closed")) {
            menuBtn.innerHTML = "☰";
        } else {
            menuBtn.innerHTML = "✕";
        }
    }
}

// ===============================
// DATE
// ===============================

function showCurrentDate() {

    const date = new Date();

    const options = {
        weekday: "short",
        year: "numeric",
        month: "short",
        day: "numeric"
    };

    document.getElementById("currentDate").textContent =
        date.toLocaleDateString("en-US", options);

}

showCurrentDate();


// ===============================
// FORMAT DATE
// ===============================

function formatDate(dateString) {

    const date = new Date(dateString + "T00:00:00");

    return date.toLocaleDateString(
        "en-US",
        {
            day: "numeric",
            month: "short",
            year: "numeric"
        }
    );

}


// ===============================
// SECURITY HELPER
// ===============================

function escapeHTML(text) {

    const div = document.createElement("div");

    div.textContent = text;

    return div.innerHTML;

}


// ===============================
// INITIAL LOAD
// ===============================

renderAll();
