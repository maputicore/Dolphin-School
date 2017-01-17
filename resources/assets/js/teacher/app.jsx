import React, { Component } from 'react';
import { Link } from 'react-router';
import $ from 'jquery';

export default class App extends Component {
    constructor(props) {
        super(props);
    }

    _getAuth() {
        $.ajax({
            url: "/teacher",
            type: "GET",
            success: (response) => {
                let auth = response.auth;
                auth.loggedIn = true;
                this.updateAuth(auth);
                this.forceUpdate();
            }.bind(this),
            error: (errors) => {
                var auth = {loggedIn: false};
                this.updateAuth(auth);
                this.forceUpdate();
            }.bind(this)
        });
    }

    _checkAuth() {
        var auth = this.auth;
        if (_.isEmpty(auth)) return false;

        var currentPath = this.getPathname();
        var guestActions = ["/login", "/register"];

        if (auth.loggedIn) {
            if (_.contains(guestActions, currentPath)) {
                this.redirectTo("dashboard");
                return false;
            }
        } else if (!_.contains(guestActions, currentPath)) {
            this.redirectTo("login");
            return false;
        }
        window.currentAdminChannel = this.auth.channel;
        return true;
    }

    componentWillMount() {
        this._getAuth();
    }

    render() {
        if (!this._checkAuth()) {
            return null;
        }
        return (
            <div>
                <ul>
                  <li>
                    {this.state.loggedIn ? (
                      <Link to="/logout">Logout</Link>
                    ) : (
                      <Link to="/login">Login</Link>
                    )}
                  </li>
                  <li><Link to="/home">Home</Link></li>
                </ul>
                {this.props.children || <p>You are {!this.state.loggedIn && 'not'} logged in.</p>}
            </div>
        );
    }
}
