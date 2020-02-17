import React, { useState } from 'react';

const TodoListItem = ({ task, callback }) => {
    /**
    * Initialisation du hook useState
    */
    const [ status, setStatus ] = useState(false);

    /**
    * Function appelée au render du bouton, gestion indépendante de son render
    */
    function renderButtons() {
        return (
            <button
                className={`todo__listItemBtn${status ? '--delete' : ''}`}
                onClick={() => {
                    setStatus(!status), status ? handleDelete() : handleComplete();
                }}
            >{`${status ? 'Delete' : 'Complete'}`}</button>
        );
    }

    /**
    * Function appelée au click du bouton lorsqu'il est sur le status complete    
    */
    function handleComplete() {
        console.log('Complete');
    }

    /**
    * Function appelée au click du bouton lorsqu'il est sur le status delete    
    */
    function handleDelete() {
        callback(task[1].id);
    }

    return (
        <li className='todo__listItem list-group-item'>
            <span className='todo__listItemLabelDate'>Date created : </span>
            {task[1].dateCreated}
            <span className='todo__listItemLabelTask'>Task : </span>
            {task[1].text}
            {renderButtons()}
        </li>
    );
};

export default TodoListItem;
