document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('todo-input');
    const addTaskBtn = document.getElementById('add-task-btn');
    const assignedList = document.getElementById('assigned-list');
    const doneList = document.getElementById('done-list');
    const sortSelect = document.getElementById('sort-select');

    function addTask(taskDescription) {
        const taskItem = document.createElement('li');
        
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.classList.add('task-checkbox');

        const taskText = document.createElement('span');
        taskText.textContent = taskDescription;
        taskText.classList.add('task-text');

        const timestamp = document.createElement('span');
        timestamp.classList.add('task-timestamp');
        timestamp.textContent = new Date().toLocaleString();

        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Delete';
        deleteBtn.classList.add('delete-btn');

        taskItem.appendChild(checkbox);
        taskItem.appendChild(taskText);
        taskItem.appendChild(timestamp);
        taskItem.appendChild(deleteBtn);

        assignedList.appendChild(taskItem);

        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                doneList.appendChild(taskItem);
            } else {
                assignedList.appendChild(taskItem);
            }
            sortTasks();
            saveTasks();
        });

        deleteBtn.addEventListener('click', () => {
            taskItem.remove();
            saveTasks();
        });

        sortTasks();
        saveTasks();
    }

    input.addEventListener('keypress', (event) => {
        if (event.key === 'Enter' && input.value.trim()) {
            addTask(input.value.trim());
            input.value = '';
        }
    });

    addTaskBtn.addEventListener('click', () => {
        if (input.value.trim()) {
            addTask(input.value.trim());
            input.value = '';
        }
    });

    function sortTasks() {
        const sortBy = sortSelect.value;
        const lists = [assignedList, doneList];

        lists.forEach(list => {
            const tasks = Array.from(list.children);
            tasks.sort((a, b) => {
                const dateA = new Date(a.querySelector('.task-timestamp').textContent);
                const dateB = new Date(b.querySelector('.task-timestamp').textContent);
                return sortBy === 'newest' ? dateB - dateA : dateA - dateB;
            });

            tasks.forEach(task => list.appendChild(task));
        });
    }

    sortSelect.addEventListener('change', sortTasks);

    function loadTasks() {
        const savedTasks = JSON.parse(localStorage.getItem('tasks')) || [];
        savedTasks.forEach(task => {
            addTask(task.description);
            if (task.done) {
                const lastTask = assignedList.lastElementChild;
                lastTask.querySelector('.task-checkbox').checked = true;
                doneList.appendChild(lastTask);
            }
        });
    }

    function saveTasks() {
        const allTasks = [...assignedList.children, ...doneList.children];
        const tasksToSave = Array.from(allTasks).map(task => ({
            description: task.querySelector('.task-text').textContent,
            done: task.parentElement === doneList
        }));
        localStorage.setItem('tasks', JSON.stringify(tasksToSave));
    }

    loadTasks();
});