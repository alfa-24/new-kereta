from pathlib import Path
import json

input_path = Path(r'c:\Users\hamzah\jalurKereta\chat-log.txt')
output_path = Path(r'c:\Users\hamzah\jalurKereta\chat-log-messages.txt')

with input_path.open('r', encoding='utf-8') as fin, output_path.open('w', encoding='utf-8') as fout:
    for line in fin:
        line = line.strip()
        if not line:
            continue
        try:
            obj = json.loads(line)
        except json.JSONDecodeError:
            continue

        t = obj.get('type', '')
        ts = obj.get('timestamp') or obj.get('data', {}).get('timestamp', '')

        if t == 'user.message':
            content = obj['data'].get('content', '').strip()
            if content:
                fout.write(f'[{ts}] USER: {content}\n')

        elif t == 'assistant.message':
            content = obj['data'].get('content', '').strip()
            if content:
                fout.write(f'[{ts}] ASSISTANT: {content}\n')
            for tool in obj['data'].get('toolRequests', []):
                name = tool.get('name')
                args = tool.get('arguments')
                if isinstance(args, str):
                    arg_text = args
                else:
                    try:
                        arg_text = json.dumps(args, ensure_ascii=False)
                    except Exception:
                        arg_text = str(args)
                fout.write(f'[{ts}] ACTION: requested tool {name} with args {arg_text}\n')

        elif t in ('tool.execution_start', 'tool.execution_complete', 'tool.execution_error'):
            data = obj.get('data', {})
            name = data.get('toolName') or data.get('name')
            args = data.get('arguments')
            result = data.get('success')
            status = 'started' if t == 'tool.execution_start' else 'completed' if t == 'tool.execution_complete' else 'error'
            if name:
                if isinstance(args, str):
                    arg_text = args
                else:
                    try:
                        arg_text = json.dumps(args, ensure_ascii=False)
                    except Exception:
                        arg_text = str(args)
                fout.write(f'[{ts}] ACTION: tool {name} {status} with args {arg_text}')
                if result is not None:
                    fout.write(f' success={result}')
                fout.write('\n')

print(f'Created {output_path}')
