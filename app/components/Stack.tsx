import { STACK_ROWS } from "../content";

export default function Stack() {
  return (
    <section id="stack" className="alt" aria-labelledby="stack-h">
      <div className="wrap">
        <div className="grid-2 reveal">
          <div className="sec-label reveal reveal-d1">
            <span className="num">02</span>Stack
          </div>
          <div className="reveal reveal-d2">
            <h2 className="sr-only" id="stack-h">Technical stack</h2>
            <table className="stack-table" aria-label="Stack by category">
              <tbody>
                {STACK_ROWS.map(row => (
                  <tr key={row.category}>
                    <th scope="row">{row.category}</th>
                    <td>
                      {row.tokens.map(t => (
                        <span key={t} className={`tok${row.highlighted.includes(t) ? " hi" : ""}`}>
                          {t}
                        </span>
                      ))}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  );
}
