import React from 'react';
import TodoListItem from '../components/todoList-item';

const TodoList = ({ todoList, callback }) => {
    /**
    * Initialisation de l'id du task à rajouter et conversion de l'objet todoList
    */
    let idTaskToAdd = 0;
    let todoListConverted = Object.entries(todoList);
    todoListConverted.map((task) => (idTaskToAdd = task.length - 1));

    /**
    * Function appelée après avoir appuyé sur le bouton delete d'un task, gestion de la suppresion du task
    */
    function receiveCallback(idToDelete) {
        const newTodoList = todoList.filter((task) => task.id !== todoList[idToDelete - 1].id);
        callback(newTodoList);
    }

    return (
        <ul>
            {todoListConverted.map((task) => (
                <TodoListItem key={task[idTaskToAdd].id} task={task} callback={receiveCallback} />
            ))}
        </ul>
    );
};

export default TodoList;
