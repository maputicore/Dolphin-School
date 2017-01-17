import React, { Component } from 'react';
export default class Home extends Component {
    render(){
        const token = auth.getToken();
        return (
            <div>
                <h1>Dashboard</h1>
                <p>You made it!</p>
                <p>{token}</p>
            </div>
        );
    }
}


