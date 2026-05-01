# Dump Rendering

## Overview

`op-unit-dump` is responsible for turning `D()` input into readable output.

The `D()` function itself does not perform rich rendering. The Dump unit does.

## What the Dump Unit Adds

The Dump unit adds the following behavior on top of the raw debug call:

- source file path output
- source line number output
- MIME-aware rendering
- HTML-oriented structured rendering
- easier array formatting
- different output strategies for HTML, CSS, JavaScript, JSON, and plain text

## File Path and Line Number

The Dump unit uses `debug_backtrace()` to obtain the caller information.

It captures:

- file
- line

Then it includes those values in the rendered debug output.

## MIME-Aware Output

The Dump unit checks the current MIME type and changes rendering behavior accordingly.

Current output modes include:

- `text/html`
- `text/css`
- `text/javascript`
- `text/json`
- `text/jsonp`
- `text/plain`
- `text/shell`

This means dump output is adapted to the current response context.

## HTML Rendering

For HTML output, the Dump unit builds structured dump metadata that includes:

- file
- line
- args

Those values are converted to JSON and embedded into HTML-oriented output.

The final visual readability is then improved by the Dump unit's CSS and JavaScript assets.

## Array Formatting

One of the most important differences from `var_dump()` is array rendering.

The Dump unit recursively formats arrays into a more readable textual structure.

This makes nested arrays much easier to scan in practical debugging work.

## Type-Oriented Readability

The Dump unit escapes and normalizes values by type before rendering.

Depending on the output mode, the visual layer then helps distinguish values more clearly than a plain native dump.

In HTML mode, the readable presentation is further improved by the Dump unit frontend assets.

## JSON Role

The Dump unit uses JSON as an internal transport format for some output modes, especially HTML and JavaScript-oriented rendering.

That means JSON is part of the rendering pipeline, but not the whole feature by itself.

The full readable result comes from:

- caller trace capture
- argument normalization
- JSON packaging where needed
- CSS / JS based presentation in HTML mode

## Summary

`op-unit-dump` is the renderer behind `D()`.

It is responsible for making debug output readable, contextual, and safer for real-world application use.
