import React, { Component } from 'react';

class InputTask extends Component {
    /**
    * Constructeur de la classe InputTask
    */
    constructor(props) {
        super(props);
        this.state = {
            taskText: '',
            placeholder: 'Entrer new todo - Press enter to add your task',
            intervalBeforeRequest: 10,
            lockRequest: false
        };
    }
    /**
    * Function appelée à chaque changement à l'intérieur de l'input, changement du state taskText dépendant de ce qui a dans le champ
    */
    handleChange(event) {
        this.setState({ taskText: event.target.value });
    }

    /**
    * Function appelée à chaque touche appuyée, vérification à savoir si la touche est Enter
    */
    handleKeyPress(event) {
        if (event.key === 'Enter' && !this.state.lockRequest) {
            this.setState({ value: event.target.value });

            this.setState({ lockRequest: true });
            setTimeout(
                function() {
                    this.sendTaskTextToApp();
                }.bind(this),
                this.state.intervalBeforeRequest
            );
        }
    }

    /**
    * Function envoyant le texte qui a été entré
    */
    sendTaskTextToApp() {
        this.props.callback(this.state.taskText);
        this.setState({ lockRequest: false });
    }

    render() {
        return (
            <div>
                <input
                    type='text'
                    className='col-md-12'
                    placeholder={this.state.placeholder}
                    onChange={this.handleChange.bind(this)}
                    onKeyPress={this.handleKeyPress.bind(this)}
                    value={this.state.taskText}
                />
            </div>
        );
    }
}

export default InputTask;
