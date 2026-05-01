# Dump Rendering

## 概要

`op-unit-dump` は、`D()` の入力を見やすい出力へ変換する役割を持ちます。

`D()` 関数自体は豊かな rendering を行いません。実際の rendering を担うのは Dump unit です。

## Dump unit が追加しているもの

Dump unit は、生の debug 呼び出しに対して次の挙動を追加します。

- source file path の出力
- source line number の出力
- MIME に応じた rendering
- HTML 向けの構造化表示
- 配列の見やすい formatting
- HTML / CSS / JavaScript / JSON / plain text ごとの出力切り替え

## file path と line number

Dump unit は `debug_backtrace()` を使って呼び出し元情報を取得します。

取得しているのは次です。

- file
- line

その後、これらを debug 出力に含めます。

## MIME に応じた出力

Dump unit は現在の MIME type を確認し、それに応じて rendering を切り替えます。

現在の出力モードには次があります。

- `text/html`
- `text/css`
- `text/javascript`
- `text/json`
- `text/jsonp`
- `text/plain`
- `text/shell`

つまり、現在のレスポンス文脈に応じて dump 出力が変化します。

## HTML rendering

HTML 出力では、Dump unit は次を含む構造化データを組み立てます。

- file
- line
- args

これらは JSON 化され、HTML 向けの出力に埋め込まれます。

その後、最終的な見やすさは Dump unit の CSS と JavaScript asset によって改善されます。

## 配列の formatting

`var_dump()` との大きな違いのひとつが、配列の描画です。

Dump unit は配列を再帰的に整形し、より読みやすいテキスト構造に変換します。

これにより、ネストした配列でも実務上かなり追いやすくなります。

## 型ごとの見やすさ

Dump unit は、型に応じて値を escape / normalize した上で rendering します。

出力モードによっては、その後の visual layer が plain dump よりも値の違いを明瞭にします。

HTML mode では、見やすさはさらに Dump unit の frontend asset によって補強されます。

## JSON の役割

Dump unit は、一部の出力モード、特に HTML と JavaScript 向け rendering において JSON を内部的な transport format として使います。

つまり、JSON は rendering pipeline の一部ではありますが、機能の全体ではありません。

最終的な見やすい結果は次の組み合わせで成立します。

- 呼び出し元 trace の取得
- 引数の normalize
- 必要に応じた JSON packaging
- HTML mode における CSS / JS ベースの presentation

## まとめ

`op-unit-dump` は `D()` の背後にある renderer です。

その役割は、debug 出力を読みやすくし、文脈を持たせ、実際のアプリケーション利用に耐える形にすることです。
