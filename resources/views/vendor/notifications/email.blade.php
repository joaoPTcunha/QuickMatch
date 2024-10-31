<div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; max-width: 600px; margin: 20px auto; background-color: #ffffff; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
    <h1 style="font-size: 24px; color: #333; font-weight: bold; margin: 20px 0; text-align: center;">
        Bem-vindo ao QuickMatch!
    </h1>
    <p style="font-size: 16px; color: #666; line-height: 1.5; text-align: center; margin-bottom: 20px;">
        Obrigado por te juntares ao QuickMatch! Para confirmar o teu registo, por favor verifica o teu e-mail clicando no botão abaixo. Este passo ajuda-nos a manter a tua conta segura.
    </p>
    <div style="text-align: center; margin: 30px 0;">
        @component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
            Verificar E-mail
        @endcomponent
    </div>
    <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #777;">
        Com os melhores cumprimentos,<br>
        <strong>Equipa QuickMatch</strong>
    </p>
    <p style="font-size: 12px; color: #999; text-align: center; margin-top: 10px;">
        Caso tenhas problemas ao clicar no botão "Verificar E-mail", copia e cola o link abaixo no teu navegador:<br>
        <a href="{{ $actionUrl }}" style="color: #3B82F6;">{{ $actionUrl }}</a>
    </p>
</div>
