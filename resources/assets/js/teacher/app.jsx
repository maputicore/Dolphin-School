import React, { Component } from 'react';
import { Link } from 'react-router';

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {
            loggedIn: true
        };
    }

    updateAuth(loggedIn) {
        this.setState({
            loggedIn: true
        });
    }

    componentWillMount() {
        // auth.onChange = this.updateAuth;
        // auth.login();
    }

    render() {
        return (
            <div>
                <ul>
                    <li>
                        <Link to="login">Login</Link>
                    </li>
                    <li><Link to="about">About</Link></li>
                </ul>
                {/*this.props.children || <p>You are {!this.state.loggedIn && 'not'} logged in.</p>*/}
            </div>
        )
    }
}

export default App;
