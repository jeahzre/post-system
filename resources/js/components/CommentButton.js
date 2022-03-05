// import axios from "axios";
import React, { useEffect, useState } from "react";
// import ReactDOM from "react-dom";

function CommentButton(props) {
  const { commented, commentCount, handleToggleMoreFeature } = props || {};

  const startCommentPost = () => {
    // history.pushState({}, document.title, `/p/${postId}`);

    handleToggleMoreFeature();
  };

  if (Object.keys(props).length > 0) {
    // console.log(commentCount);
    return (
      <div className="d-flex">
        <div className="d-flex align-items-center px-2 border border-secondary bg-dark rounded-start">{commentCount}</div>
        <button
          className={`btn btn${commented ? "" : "-outline"}-secondary custom-btn-radius`}
          onClick={startCommentPost}
        >
          comment
        </button>
      </div>
    );
  } else {
    return null;
  }
}

export default CommentButton;
