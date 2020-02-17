/**
 * @author Gabriel Chouinard Létourneau <chouinardletourneaug@gmail.com>
 * @version Finale
 * @todo Challenge venant de Git N Gin, todo list
 */

import React, { Component } from 'react';
import InputTask from '../components/input-task';
import TodoList from './TodoList';
import moment from 'moment';

/**
* Utilisation de nano-react pour une rapidité de développement, dans ce cas-ci, plus rapide
*/
export default class App extends Component {
    /**
    * Constructeur de la classe App
    */
    constructor(props) {
        super(props);

        this.state = {
            todoList: []
        };
    }

    /**
    * Function gêrant le taskText reçu par le callback de l'input
    */
    receiveTaskText(taskText) {
        const taskToAdd = {
            id: 0,
            text: '',
            dateCreated: ''
        };
        /**
        * Création des données de chaque objet Task qui seront par la suite envoyé dans l'array du state todoList
        */
        taskToAdd.id = this.state.todoList.length + 1;
        taskToAdd.text = taskText;
        taskToAdd.dateCreated = moment().format('MMMM Do YYYY, h:mm:ss a');

        const todoListItems = [ ...this.state.todoList ];
        todoListItems.push(taskToAdd);

        this.setState({
            todoList: todoListItems
        });
    }

    render() {
        /**
        * Gestion du callback envoyé par le container TodoList et mis à jour du state todoList
        */
        const handleDeleteCallback = (newTodoList) => {
            this.setState({
                todoList: newTodoList
            });
        };

        /**
        * Render indépendant de la todo list et début de gestion du callback
        */
        const renderTodoList = () => {
            if (this.state.todoList.length > 0) {
                return (
                    <div className='todo__list'>
                        <TodoList todoList={this.state.todoList} callback={handleDeleteCallback} />
                    </div>
                );
            }
        };
        return (
            <div className='row todo'>
                <div className='todo__container'>
                    <h1 className='todo__title'>To do list!</h1>
                    <InputTask callback={this.receiveTaskText.bind(this)} />
                    {renderTodoList()}
                </div>
            </div>
        );
    }
}
