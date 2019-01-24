import React from "react";

class Entry extends React.Component {

    renderImage() {
        return <img src={this.props.content} className="img-fluid img-thumbnail" alt="Responsive image"/>
    }

    renderText() {
        return <div className="list-group-item list-group-item-action flex-column align-items-start">
            <p className="mb-1">{this.props.content}</p>

        </div>
    }

    render() {
        return <div className="list-group">
            {this.props.type === 'image' && this.renderImage()}
            {this.props.type === 'text' && this.renderText()}
        </div>
    }
}

export default Entry;